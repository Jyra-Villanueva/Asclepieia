<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Asclepieia</title>
    <style>
        body {
            background-image: url('logo/thankyou.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; 
            color: #5C8374;
            margin: 0; 
            padding: 0; 
            background-color: #f0f0f0;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            overflow-x: hidden;
            text-align: center;
        }

        img {
            width: 100%;
            height: auto;
            margin: 20px 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-weight: 200;
            color: #435d56;
            font-size: 24px;
        }

        p {
            color: #555;
            font-size: 18px;
            margin-bottom: 20px;
        }

        #termsContainer {
            max-height: 300px;
            overflow-y: scroll;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            text-align: left; 
        }

        #agreeCheckboxLabel {
            display: block;
            margin-top: 10px;
            text-align: left; 
        }

        #agreeCheckboxError {
            color: #ff0000; 
            display: none; 
            margin-top: 5px;
        }

        .get-started-button {
            margin-top: 30px;
            margin-bottom: 20px;
            display: inline-block;
            background-color: #435d56;
            color: #fff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .get-started-button:hover {
            background-color: #E9E9E9;
            color: #435d56;
        }

        #terms{
            margin-top: 200px;
        }
    </style>
</head>
<body>

    <div id="terms" class="container">
        <h1>Welcome to Asclepieia!</h1>
        <p>We're thrilled to have you on board. Explore the app and discover a world of health and wellness. If you have any questions, feel free to reach out. Happy exploring!</p>

        <div id="termsContainer">
            <h2>Terms and Conditions</h2>
            <p>
                1. <strong>Educational Purpose:</strong> Asclepieia is designed for educational purposes only. The information provided about plants, their medicinal properties, and uses is meant to be informative and should not be considered a substitute for professional medical advice.
            </p>
            <p>
                2. <strong>Not a Prescription:</strong> The content in Asclepieia is not intended to be a prescription or a substitute for professional medical diagnosis, treatment, or advice. Users are strongly advised to consult with a qualified healthcare professional for any medical concerns or conditions.
            </p>
            <p>
                3. <strong>Consult a Doctor:</strong> While Asclepieia provides valuable insights into the world of plants and their potential benefits, it is crucial to consult a doctor or qualified healthcare provider for personalized medical advice, especially in case of medical complications, allergies, or specific health conditions.
            </p>
            <p>
                4. <strong>Accuracy of Information:</strong> We strive to provide accurate and up-to-date information, but the field of botanical knowledge is dynamic. Users should verify information independently and consult authoritative sources for the latest research and medical guidance.
            </p>
            <p>
                5. <strong>User Responsibility:</strong> sers are responsible for their own health decisions and should exercise caution when using any plant-based remedies. Asclepieia does not endorse self-diagnosis or self-treatment.
            </p>
            <p>
            By using Asclepieia, you agree to these terms and conditions. If you do not agree, please refrain from using the app. Asclepieia is here to enhance your botanical knowledge and appreciation, and we encourage you to enjoy it responsibly.
            </p>
            <p>
            Thank you for choosing Asclepieia - Your Plant Companion App!
            </p>
        </div>

        <form action="homepage.php" method="post" onsubmit="return validateForm()">
            <label for="agreeCheckbox" id="agreeCheckboxLabel">
                <input type="checkbox" id="agreeCheckbox" name="agreeCheckbox" required>
                I have read and agree to the <a href="#termsContainer">Terms and Conditions</a>.
            </label>
            <div id="agreeCheckboxError">Please agree to the Terms and Conditions.</div>
            <button type="submit" class="get-started-button">NEXT</button>
        </form>
    </div>

    <script>
        function validateForm() {
            var checkbox = document.getElementById("agreeCheckbox");
            var errorDiv = document.getElementById("agreeCheckboxError");

            if (!checkbox.checked) {
                errorDiv.style.display = "block";
                return false;
            } else {
                errorDiv.style.display = "none";
                return true;
            }
        }
    </script>
</body>
</html>
