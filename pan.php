<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect them to the login page
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAN Card Generator</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
            padding: 0;
    margin: 0;
    box-sizing: border-box;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
        }

        input {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .pan-card {
            width: 1266px;
            height: 367px;
            position: relative;
            /* border: 1px solid #000; */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
            border-radius: 10px;
        }

        .pan-card img {
            position: absolute;
            object-fit: cover;
        }

        .pan-card #background-image {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .pan-card .profile-image {
            width: 100px;
            height: 100px;
            /* border-radius: 50%; */
            bottom: 36px;
            right: 703px;
            z-index: 1;
        }

        .pan-card .signature {
            width: 110px;
            height: 30px;
            bottom: 65px;
            left: 20px;
            z-index: 1;
        }

        .pan-card h2 {
            position: absolute;
            font-size: 18px;
            top: 102px;
            left: 22px;
            margin: 0;
            z-index: 1;
        }

        .pan-card p {
            position: absolute;
            font-size: 16px;
            margin: 0;
            z-index: 1;
            font-weight: bold;
        }

        .pan-card .pan-number {
            top: 200px;
            left: 22px;
        }

        .pan-card .dob {
            top: 166px;
            left: 22px;
        }

        .pan-card .fname {
            top: 135px;
            left: 22px;
        }

        .pan-card .qr-code {
            position: absolute;
            top: 117px;
            right: 896px;

        }

        #download-btn {
            margin-top: 10px;
        }
        .logout_btn a{
            color: #f4f4f9;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>Fill the pan Form</h1><button class="logout_btn"><a href="logout.php">Logout</a></button>
        <form id="panForm">
            <label for="name">Name:</label>
            <input type="text" id="name" required>

            <label for="fname">Father Name:</label>
            <input type="text" id="fname" required>

            <label for="pan">PAN Number:</label>
            <input type="text" id="pan" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" required>

            <label for="image">Upload Profile Image:</label>
            <input type="file" id="image" accept="image/*" required>

            <label for="signature">Upload Signature:</label><br>
            <input type="file" id="signature" accept="image/*" required>
            <!-- 
            <label for="background">Upload Backgroundimg:</label><br>
            <input type="file" id="background" accept="image" > -->

            <button type="submit">Generate PAN Card</button>
        </form>


        <div id="pan-card-container" class="pan-card" style="display:none;">
            <img id="background-image" src="" alt="Background">
            <img id="profile-image" class="profile-image" src="" alt="Profile Image">
            <img id="signature-image" class="signature" src="" alt="Signature">
            <canvas id="qr-code" class="qr-code"></canvas>
            <h2 id="card-name"></h2>
            <p id="card-fname" class="fname"></p>
            <p id="card-pan" class="pan-number"></p>
            <p id="card-dob" class="dob"></p>
        </div>

        <button id="download-btn" style="display:none;">Download PAN Card</button>
    </div>
    <script>
        const form = document.getElementById('panForm');
        const panCardContainer = document.getElementById('pan-card-container');
        const profileImage = document.getElementById('profile-image');
        const profileImageurl = document.getElementById('background-image');
        const signatureImage = document.getElementById('signature-image');
        const cardName = document.getElementById('card-name');
        const cardFName = document.getElementById('card-fname');
        const cardPan = document.getElementById('card-pan');
        const cardDob = document.getElementById('card-dob');
        const qrCodeCanvas = document.getElementById('qr-code');
        const downloadBtn = document.getElementById('download-btn');





        form.addEventListener('submit', (e) => {
            e.preventDefault();


            const name = document.getElementById('name').value;
            const fname = document.getElementById('fname').value;
            const pan = document.getElementById('pan').value;
            const dob = document.getElementById('dob').value;
            const imageFile = document.getElementById('image').files[0];
            const signatureFile = document.getElementById('signature').files[0];
            const backgroundurl = "./img/pancard.png";
            console.log(backgroundurl);
            if (imageFile && signatureFile && backgroundurl) {
                const imageReader = new FileReader();
                const signatureReader = new FileReader();

                profileImageurl.src = backgroundurl;

                imageReader.onload = function(event) {
                    profileImage.src = event.target.result;
                };

                signatureReader.onload = function(event) {
                    signatureImage.src = event.target.result;
                };

                imageReader.readAsDataURL(imageFile);
                signatureReader.readAsDataURL(signatureFile);


                cardName.textContent = `Name: ${name}`;
                cardFName.textContent = `Father Name: ${fname}`;
                cardPan.textContent = `PAN: ${pan}`;
                cardDob.textContent = `DOB: ${dob}`;


                const qrData = `Name: ${name}\nFather Name: ${fname}\nPAN: ${pan}\nDOB: ${dob}`;
                QRCode.toCanvas(qrCodeCanvas, qrData, {
                    width: 100
                }, function(error) {
                    if (error) console.error(error);
                });


                panCardContainer.style.display = 'block';
                downloadBtn.style.display = 'block';
            }
        });

        // downloadBtn.addEventListener('click', () => {
        //     html2canvas(panCardContainer, { useCORS: true }).then((canvas) => {
        //         const link = document.createElement('a');
        //         link.href = canvas.toDataURL('image/png');
        //         link.download = 'pan_card.png';
        //         link.click();
        //     });
        // });
        downloadBtn.addEventListener('click', function() {
            html2canvas(panCardContainer, {
                useCORS: true
            }).then(function(canvas) {
                const imgData = canvas.toDataURL("image/png");
                console.log(imgData);
                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: "portrait",
                    unit: "mm",
                    format: "a4",
                });
                const padding = 10;


                const pageWidth = pdf.internal.pageSize.width;
                const pageHeight = pdf.internal.pageSize.height;
                const scaleX = (pageWidth - 2 * padding) / canvas.width;
                const scaleY = (pageHeight - 2 * padding) / canvas.height;
                const scale = Math.min(scaleX, scaleY);


                pdf.addImage(imgData, 'PNG', padding, padding, canvas.width * scale, canvas.height * scale);


                pdf.save('Duplicate_PAN_Card.pdf');
            }).catch(function(error) {
                console.error("Error generating the PDF:", error);
            });
        });
    </script>

</body>

</html>