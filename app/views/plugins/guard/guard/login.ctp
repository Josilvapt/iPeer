<div align="center" class="login">
  <h4>iPeer Login</h4>
<!-- begin login form -->
  <?php echo $this->element('login_' . Inflector::underscore($auth_module_name), array('login_url', $login_url, 'is_logged_in' => $is_logged_in))?>
<!-- end login form -->
</div>

<script type="text/javascript">
console.log("blah");
jQuery('#GuardUsername').focus();
</script>
