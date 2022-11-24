<!DOCTYPE html>
<html lang="en">
  <head>
	<script>
		function downloadpage()
  		{
      		var hiddenElement = document.createElement('a');
			var currentpage = document.getElementById('maintext').innerHTML;
      		hiddenElement.href = 'data:attachment/text,' + encodeURI(currentpage);
      		hiddenElement.target = '_blank';
      		hiddenElement.download = 'notfollowingback_'+Date.now()+'.html';
      		hiddenElement.click();
  		}
	</script>
	  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="theme-color" content="#2C4DC1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Check who doesn't follow back on Instagram. Login not required.">
	<meta name="keywords" content="Insta, Instagram, Followback, Follow4Follow, Tools, Social media Tools, Social Media Analysis, Instagram Analysis, Instagram Boost, IG, Follow Back, Follow Back Check">
    <title>Instagram Following Back Checker - Check who doesn't follow back on Instagram - Instafollowingback.com</title>
	<link rel="icon" type="image/x-icon" href="/images/favicon.png" sizes="16x16">
    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="./">Instagram Following Back Checker</a>
    </nav>
    <div class="container mt-2">
      <div class="row">
        <div class="col-12">
          <div class="jumbotron">
            <h1 class="text-center">Instagram Following Back Checker</h1>
            <div class="row justify-content-center">
			  <div class="col-auto">
				   <form enctype="multipart/form-data" action="index.php" method="POST" id="igdumpfilesubmit">
					 <div class="col-auto">
                          <p><label for="following_file" class="btn btn-primary btn-lg" role="button" id="following">Select Following.html</a></p>
						  <span id="following_file_chosen" >No following file chosen</span>
						  
                     </div>
    				 <input type="file" accept="text/html" name="following_file" id="following_file" hidden></input><br/>
				     <div class="col-auto">
                          <p><label for="followers_file" class="btn btn-primary btn-lg"  role="button" id="followers">Select Followers.html</a></p>
						  <span id="followers_file_chosen" >No followers file chosen</span> 
						  
                     </div>
				     <input type="file" accept="text/html" name="followers_file" id="followers_file" hidden></input><br/>
    				 <input type="submit" value="Check" id="submit_list" hidden></input>
			         <div class="col-auto">
			              <p><label for="submit_list" class="btn btn-dark btn-lg" role="button" id="checkbtn">Check</a> </p>
			         </div>
  				   </form>
              </div>
            </div>
		    </br>
            <p class="text-center" id="maintext">Check who doesn't follow back on Instagram. Login not required.</br>Accounts are shown in chronological order by default.</br></p><b><p style="color:red;" id="maintext1" class="text-center">It works by comparing following.html with followers.html from the dumped Instagram archive </br>without the need of interacting with Instagram servers to avoid a ban due to using third-party applications.</p></b>
			<p class="text-center" id="dump_tutorial"><b>How to dump Instagram Archive</br></b> On Mobile Devices: Your activity - Download your information - Request Download</br>On Computers: More - Settings - Privacy and security - Data download - Request download - <b>Select HTML</b></br></br><b><a href="https://help.instagram.com/181231772500920/" style="color:green;" target="_blank">Link to the official Instagram help center</a></b></br></br><b>How to use this site</b></br><b><a href="https://help.instafollowingback.com" style="color:blue;" target="_blank">Click here for the tutorial</a></b></p></br>
          </div>
        </div>
      </div>
    </div>
    <footer class="text-center">
      <div class="container">
        <div class="row">
          <div class="col-12">
            
          </div>
        </div>
      </div>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
  </body>
</html>

<?PHP
  function generateRandomString($length = 20) 
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
  function check_followers($following, $followers)
  {
	  $randst = generateRandomString();
	  passthru('python3 ./scripts/instafollowback.py -i "./following_tmp/' . $following . '" -e "./followers_tmp/' . $followers . '" > ./tmp/' . $randst, $errcode);
	  if($errcode != 0)
	  {
		  echo '<script type="text/JavaScript"> alert("Error: An error occured while processing file. Please make sure following and followers files are selected correctly."); </script>';
		  echo '<meta http-equiv="refresh" content="0; url=./">';
	  }
	  $output = file_get_contents("./tmp/". $randst);
	  echo '<script type="text/JavaScript"> document.getElementById("igdumpfilesubmit").style.display = "none" </script>';
	  echo '<script type="text/JavaScript"> document.getElementById("following").style.display = "none" </script>'; //hide the buttons
	  echo '<script type="text/JavaScript"> document.getElementById("followers").style.display = "none" </script>';
	  echo '<script type="text/JavaScript"> document.getElementById("following_file_chosen").style.display = "none" </script>';
	  echo '<script type="text/JavaScript"> document.getElementById("followers_file_chosen").style.display = "none" </script>';
	  echo '<script type="text/JavaScript"> document.getElementById("checkbtn").style.display = "none" </script>';
	  echo '<script type="text/JavaScript"> document.getElementById("maintext1").innerHTML = "" </script>';
	  echo '<script type="text/JavaScript"> document.getElementById("dump_tutorial").innerHTML = "" </script>';
	  echo '<script type="text/JavaScript"> document.getElementById("maintext").innerHTML = "<p><button \" onclick=\"downloadpage();\" class=\"btn btn-light\" role=\"button\" id=\"back_home_page\">Download the result as HTML</button> </p>'. $output .' </br><p><a href=\"./ \" class=\"btn btn-success btn-lg\" role=\"button\" id=\"back_home_page\">Return</a> </p>" </script>';
	  exec("rm -f ./followers_tmp/". basename($followers));
	  exec("rm -f ./following_tmp/" . basename($following));
	  exec("rm -f ./tmp/". $randst);
  }

  if(!empty($_FILES['following_file']))
  {
	if(preg_match('/text\/*/',$_FILES['following_file']['type'])){
		$path = "./following_tmp/";
		$randname = generateRandomString();
    	$path = $path . basename($_FILES['following_file']['name']) . $randname;
    	if(move_uploaded_file($_FILES['following_file']['tmp_name'], $path)) {
			$following_file=$_FILES['following_file']['name'] . $randname;
    	}
	}
	else
	{
		echo '<script type="text/JavaScript"> alert("Error: Following file must be HTML format."); </script>';
		echo '<meta http-equiv="refresh" content="0; url=./">';
	}
  }

  if(!empty($_FILES['followers_file']))
  {
	if(preg_match('/text\/*/',$_FILES['followers_file']['type'])){
		$path = "./followers_tmp/";
		$randname = generateRandomString();
    	$path = $path . basename($_FILES['followers_file']['name']) . $randname;
    	if(move_uploaded_file($_FILES['followers_file']['tmp_name'], $path)) {
			$followers_file=$_FILES['followers_file']['name'] . $randname;
    	}
	}
	else
	{
		echo '<script type="text/JavaScript"> alert("Error: Followers file must be HTML format."); </script>';
		echo '<meta http-equiv="refresh" content="0; url=./">';
	}
  }

  if(!empty($_FILES['followers_file']) && !empty($_FILES['following_file']))
  {
	  check_followers($following_file, $followers_file);
  }
?>

	<script type="text/JavaScript">
		const actualBtn = document.getElementById('following_file');
		const fileChosen = document.getElementById('following_file_chosen');
		actualBtn.addEventListener('change', function(){
  		fileChosen.textContent = this.files[0].name
		})
	</script>

	<script type="text/JavaScript">
		const actualBtn2 = document.getElementById('followers_file');
		const fileChosen2 = document.getElementById('followers_file_chosen');
		actualBtn2.addEventListener('change', function(){
  		fileChosen2.textContent = this.files[0].name
		})
	</script>
