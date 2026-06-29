import paramiko
import sys
sys.stdout.reconfigure(encoding='utf-8')

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('157.66.9.133', username='root', password='r00tunisa@#_')

php_script = """<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();
$user = \\App\\Models\\User::where('email', 'immkorkom@unisayogya.ac.id')->first();
$user->password = \\Illuminate\\Support\\Facades\\Hash::make('immkorkom2024@#');
$user->save();
echo "Password updated strictly\\n";
"""

ssh.exec_command(f"cat << 'EOF' > /root/update_pass.php\n{php_script}\nEOF")
ssh.exec_command("docker cp /root/update_pass.php korkomunisa_app:/var/www/html/update_pass.php")
stdin, stdout, stderr = ssh.exec_command("docker exec korkomunisa_app php update_pass.php")

for line in iter(stdout.readline, ""):
    print(line, end="")
for line in iter(stderr.readline, ""):
    print(line, end="")
ssh.close()
