<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beltei Tours</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        #scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        #scroll-to-top a {
            color: #fff;
            /* Change the color of the button text */
            text-decoration: none;
            font-weight: bold;
        }

        #scroll-to-top:hover {
            background-color: rgba(255, 255, 255, 0.3);
            /* Change the background color on hover */
        }

        #login-button {
            position: fixed;
            top: 20px;
            right: 20px;
        }
    </style>
    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        window.onscroll = function () {
            var scrollButton = document.getElementById('scroll-to-top');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollButton.style.display = 'block';
            } else {
                scrollButton.style.display = 'none';
            }
        };
    </script>
</head>

<body style="background-color:#7ba46a; font-family: Khmer OS Siemreap;">
    <div class="container my-5" style="background-color: white;">
        <div>
            <?php include("header.php"); ?>
            <hr />
        </div>
        <a id="login-button" class="btn btn-primary" href="form.php">Login</a>
        <div class="row">
            <div class="col-md-2" style="border-right: 1px solid gray;">
                <?php include("leftside.php"); ?>
            </div>
            <div class="col-md-8" style="border-top: 1px dotted gray;">
                <?php include("CenterSide.php"); ?>
            </div>
            <div class="col-md-2" style="border-left: 1px solid gray;">
                <?php include("rightside.php"); ?>
            </div>
        </div>
        <div>
            <center>
                <p style="color: red; font-size: 24px; font-weight: bold;">
                    ព័ត៌មានលំអិតសូមចុចមើលសៀវភៅព័ត៌មានខាងក្រោម
                </p>
            </center>
        </div>
        <div>
            <?php include("footer.php"); ?>
        </div>
        <div id="scroll-to-top">
            <a href="#" onclick="scrollToTop(); return false;">Back to Top</a>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
</body>

</html>
