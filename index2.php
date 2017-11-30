<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header2.php");
?>
   <form class="form-signin">
        <label for="inputEmail" class="sr-only"></label><br />
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus><br />
        <label for="inputPassword" class="sr-only"></label><br />
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
      </form>
<?php
require_once(TEMPLATE_PATH . "/footer2.php");
?>