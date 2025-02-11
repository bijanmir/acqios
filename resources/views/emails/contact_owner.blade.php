<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Inquiry About Your Listing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        .button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Hi {{ $listing->user->name }},</h2>

    <p><strong>{{ $sender->name }}</strong> is interested in your listing on Acqios.</p>

    <p><strong>Listing:</strong> <a href="{{ route('listings.show', $listing->id) }}">{{ $listing->title }}</a></p>

    <p>You can contact them at: <strong>{{ $sender->email }}</strong></p>

    <a href="{{ route('listings.show', $listing->id) }}" class="button">View Listing</a>

    <p>Best Regards, <br>Acqios Team</p>
</div>

</body>
</html>
