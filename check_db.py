import paramiko
import sys
sys.stdout.reconfigure(encoding='utf-8')

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('157.66.9.133', username='root', password='r00tunisa@#_')

cmd = "docker exec korkomunisa_app php artisan tinker --execute=\"print_r(\\App\\Models\\User::all()->toArray());\""
stdin, stdout, stderr = ssh.exec_command(cmd)
for line in iter(stdout.readline, ""):
    print(line, end="")
for line in iter(stderr.readline, ""):
    print(line, end="")
ssh.close()
