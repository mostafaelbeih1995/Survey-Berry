<html>

  <head>

    <title>

        SurveyBerry

    </title>

      <meta charset="UTF-8">

      <meta name="viewport"

            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

      <meta http-equiv="X-UA-Compatible" content="ie=edge">

      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

      <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">

      <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
      <link rel = "icon" href = "../images/raspberry.png">

      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <script src="myscript.js" type="text/javascript"></script>
      <script src="jquery-3.1.1.js"></script>



 </head>

 <body>

   <div class = "logo-title">

            <h1>SurveyBerry11<img src = "../images/raspberry.png"></h1>

      </div>

      <div class = "container">
        <div class = "main">
          <div class = "row">
            <div class = "col-md-4 col-md-offset-4">
              <h2>Restore Password:</h2>
              <div class = "login">
                    <form action="resetCheck.php" method="post">

                      <div class="form-group">

                        <input type="email" class="form-control" id="email" name ="user_email" placeholder="Email">

                      </div>

                      <div class = "form-group">
                          <h3>What's your Date of Birth:</h3><input type = "date" name = "dob">
                       </div>

                       <h3>Security Question 1</h3>
                      <div class = "form-group">
                          <select class = "selectpicker" name = "security_question_one" title = "security question ">
                            <option value = "pet">What's you favourite pet?</option>
                            <option value = "travel">Where do you want to travel?</option>
                            <option value = "color">What's you favourite color?</option>
                          </select>
                      </div>



                      <div class="form-group">

                        <input type="answer" class="form-control" id="pwd" name = "answer1" placeholder="answer">

                      </div>
                      <h3>Security Question 2</h3>
                      <div class = "form-group">
                          <select class = "selectpicker" name = "security_question_two" title = "security question ">
                            <option value = "hobby">What's you favourite hobby?</option>
                            <option value = "sport">What sport do you like the most ?</option>
                            <option value = "movie">What's your favourite movie?</option>
                          </select>
                      </div>

                      <div class="form-group">

                        <input type="answer" class="form-control" id="pwd" name = "answer2" placeholder="answer">

                      </div>
                    

                      <div class = "login-button">

                        <!-- <a href = "uploadPage.html"><i class="fa fa-arrow-circle-right fa-lg" aria-hidden="true"></i></a> -->

                      <button type = "submit"><i class="fa fa-arrow-circle-right fa-lg" aria-hidden="true"></i></button>

                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>

 </body>

  </html>