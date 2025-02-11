<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Inquiry About Your Listing</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f9;
            color: #333;
            line-height: 1.6;
            padding: 0;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 40px auto;
            text-align: center;
            border: 1px solid #e1e1e1;
        }
        .logo {
            width: 180px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #222;
            margin-bottom: 15px;
        }
        .content {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }
        .highlight {
            font-weight: bold;
            color: #007BFF;
        }
        .button {
            background: linear-gradient(45deg, #007BFF, #0056b3);
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(0, 123, 255, 0.2);
        }
        .button:hover {
            background: linear-gradient(45deg, #0056b3, #003580);
            transform: scale(1.05);
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Logo -->
    <img src="https://acqios.com/images/acqios_logo.png" alt="Acqios Logo" class="logo">

    <!-- Title -->
    <h2 class="title">New Inquiry About Your Listing</h2>

    <!-- Email Content -->
    <p class="content">Hi <span class="highlight">{{ $listing->user->name }}</span>,</p>

    <p class="content"><strong>{{ $sender->name }}</strong> is interested in your listing on <strong>Acqios</strong>.</p>

    <p class="content"><strong>Listing:</strong> <a href="{{ route('listings.show', $listing->id) }}" class="highlight">{{ $listing->title }}</a></p>

    <p class="content">You can contact them at: <strong>{{ $sender->email }}</strong></p>

    <!-- Call-to-Action Button -->
    <a href="{{ route('listings.show', $listing->id) }}" class="button">View Listing</a>

    <!-- Footer -->
    <p class="footer">
        Best Regards,<br>
        <strong>Acqios Team</strong><br>
        <a href="https://acqios.com">Visit Acqios</a> | <a href="mailto:support@acqios.com">Contact Support</a><br>
        © {{ date('Y') }} Acqios. All rights reserved.
    </p>

</div>

</body>
</html>
