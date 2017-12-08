<?php
echo 'Nginx: ' . print_r(shell_exec('nginx -v'));
echo '<p></p>';
echo 'apache2: ' . print_r(shell_exec('apache2 -v'));
echo '<p></p>';
echo 'httpd: ' . print_r(shell_exec('httpd -v'));
echo '<p></p>';
echo 'user: ' . print_r(shell_exec('whoami'));