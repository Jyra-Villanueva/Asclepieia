<style>
        body {
            background-image: url('logo/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; 
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: -1;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            border: none;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            max-height: 200px;
            object-fit: cover;
        }

        .card-title {
            color: #405de6;
            cursor: pointer; 
            transition: text-decoration 0.2s; 
        }

        .card-title:hover {
            text-decoration: underline; 
        }

        .card-text {
            color: #333;
        }

        .btn-primary {
            background-color: #405de6;
            border: none;
        }

        .btn-primary:hover {
            background-color: #34495e;
        }
    </style>