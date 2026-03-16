<!DOCTYPE html>
<html>
<head>
    <title>Welcome to School Management System</title>

    <style>
        body{
            margin:0;
            padding:0;
            font-family: Arial, Helvetica, sans-serif;
            background:#f4f6f9;
        }

        .container{
            max-width:700px;
            margin:40px auto;
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }

        .header{
            background:#4CAF50;
            color:white;
            padding:30px;
            text-align:center;
        }

        .header h1{
            margin:0;
        }

        .content{
            padding:30px;
            color:#444;
            line-height:1.6;
        }

        .btn{
            display:inline-block;
            padding:12px 25px;
            background:#4CAF50;
            color:white;
            text-decoration:none;
            border-radius:5px;
            margin-top:20px;
        }

        .footer{
            background:#f1f1f1;
            padding:15px;
            text-align:center;
            font-size:14px;
            color:#777;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="header">
        <h1>Welcome {{ $user->name }} 🎓</h1>
        <p>School Management System</p>
    </div>

    <div class="content">

        <p>Dear <strong>{{ $user->name }}</strong>,</p>

        <p>
            We are delighted to welcome you to our <b>School Management System</b>. 
            Your account has been successfully created and you are now a part of our academic community.
        </p>

        <p>
            This platform will help you easily manage your academic activities including:
        </p>

         
        <p>
            Our goal is to make education management simple, transparent, and efficient for students, teachers, and parents.
        </p>

        <p>
            If you have any questions or need assistance, please feel free to contact our support team.
        </p>

         

        <p style="margin-top:30px;">
            <i>"Education is the most powerful weapon which you can use to change the world."</i>
        </p>

        <p>Best Regards,<br>
        <b>School Management Team</b></p>

    </div>

    <div class="footer">
        © {{ date('Y') }} School Management System | All Rights Reserved
    </div>

</div>

</body>
</html>