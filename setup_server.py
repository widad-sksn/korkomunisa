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
    "apt-get update -y",
    "sed -i \"s/#$nrconf{restart} = 'i';/$nrconf{restart} = 'a';/g\" /etc/needrestart/needrestart.conf || true",
    "DEBIAN_FRONTEND=noninteractive apt-get install -y -q -o Dpkg::Options::='--force-confdef' -o Dpkg::Options::='--force-confold' docker.io docker-compose-v2 git curl unzip sqlite3",
    "systemctl enable --now docker",
    "mkdir -p /root/.ssh",
    "if [ ! -f /root/.ssh/github_deploy ]; then ssh-keygen -t ed25519 -f /root/.ssh/github_deploy -N ''; fi",
    "grep -qxF \"$(cat /root/.ssh/github_deploy.pub)\" /root/.ssh/authorized_keys || cat /root/.ssh/github_deploy.pub >> /root/.ssh/authorized_keys",
    "ssh-keyscan github.com >> /root/.ssh/known_hosts",
    "mkdir -p /var/www",
    "if [ ! -d /var/www/korkomunisa ]; then git clone https://github.com/widad-sksn/korkomunisa.git /var/www/korkomunisa; else cd /var/www/korkomunisa && git pull origin main; fi",
    "cd /var/www/korkomunisa && docker compose up -d --build"
]

for cmd in commands:
    run_cmd(ssh, cmd)

print("\n--- PRIVATE KEY FOR GITHUB ACTIONS ---")
run_cmd(ssh, "cat /root/.ssh/github_deploy")
print("--------------------------------------")

ssh.close()
