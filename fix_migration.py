import paramiko
import sys

sys.stdout.reconfigure(encoding='utf-8')

def run_cmd(ssh, cmd):
    print(f"Executing: {cmd}")
    stdin, stdout, stderr = ssh.exec_command(cmd)
    
    for line in iter(stdout.readline, ""):
        print(line, end="")
    for line in iter(stderr.readline, ""):
        print(line, end="")
        
    exit_status = stdout.channel.recv_exit_status()
    if exit_status != 0:
        print(f"Command failed with exit status {exit_status}")
    return exit_status

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    print("Connecting to server...")
    ssh.connect('157.66.9.133', username='root', password='r00tunisa@#_')
except Exception as e:
    print(f"Failed to connect: {e}")
    sys.exit(1)

commands = [
    "docker cp /var/www/korkomunisa/database/migrations/2026_06_29_165337_add_komisariat_and_avatar_to_users_table.php korkomunisa_app:/var/www/html/database/migrations/",
    "docker exec korkomunisa_app php artisan migrate --force"
]

for cmd in commands:
    run_cmd(ssh, cmd)

ssh.close()
