<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$subject}}</title>
</head>
<body>
    <h4>Dear {{$name_user}}</h4>

    <p>
Your Booking has been confirmed. Below are the details
    </p>
    <p>
Booking date: {{$date_time}}
    </p>
    <p>
        Duration: {{$duration}}
    </p>
    <p>
        Owner Email: {{$owner_email}}
    </p>
    <p>Owner phone: {{$owner_phone}}</p>
    <p>
        Address: {{$address}}
    </p>
    <p>
        Postcode: {{$postcode}}
    </p>
    <p>
        Amount: £{{$amount}}
    </p>

    <h3>Thank you</h3>

</body>
</html>

