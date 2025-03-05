/* Nmap Commands Keeper - Initial Setup */

-- Create database
CREATE DATABASE nmap_keeper;

-- Use the database
USE nmap_keeper;

-- Create table for storing Nmap commands
CREATE TABLE nmap_commands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    command TEXT NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Create table for storing command execution logs
CREATE TABLE command_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    command_id INT NOT NULL,
    output TEXT,
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (command_id) REFERENCES nmap_commands(id) ON DELETE CASCADE
);


-- Basic insert statement for vcommands to fill up the DB(Add your later via the form or through here!)
INSERT INTO nmap_commands (command, description, category) VALUES
('nmap -A 192.168.1.1', 'Performs an aggressive scan including OS detection, version detection, script scanning, and traceroute.', 'Aggressive Scan, OS Detection'),
('nmap -O 192.168.1.1', 'Detects the operating system of the target host.', 'OS Detection'),
('nmap -sV 192.168.1.1', 'Detects service versions running on open ports.', 'Version Detection, Service Scan'),
('nmap -sS 192.168.1.1', 'Performs a stealthy SYN scan to detect open ports without establishing a full connection.', 'Stealth Scan, TCP Scan'),
('nmap -p 80,443 192.168.1.1', 'Scans only specific ports (80 and 443 in this case).', 'Port Scanning, TCP'),
('nmap -p- 192.168.1.1', 'Scans all 65535 ports on the target.', 'Full Port Scan, TCP'),
('nmap -sU 192.168.1.1', 'Scans for open UDP ports on the target.', 'UDP Scan, Port Scanning'),
('nmap -F 192.168.1.1', 'Performs a fast scan by scanning only the most common 100 ports.', 'Fast Scan, Port Scanning'),
('nmap -D RND:10 192.168.1.1', 'Uses decoys to hide the real scanning source, useful for evading firewalls.', 'Firewall Evasion, Stealth Scan'),
('nmap --script=vuln 192.168.1.1', 'Runs vulnerability detection scripts on the target.', 'Vulnerability Scan, Script Scan'),
('nmap -sC 192.168.1.1', 'Runs the default set of NSE scripts.', 'Script Scan, Security Testing'),
('nmap -sN 192.168.1.1', 'Performs a NULL scan to check for open ports without setting TCP flags.', 'Stealth Scan, Firewall Evasion'),
('nmap -sX 192.168.1.1', 'Performs an Xmas scan, setting FIN, PSH, and URG flags.', 'Stealth Scan, Firewall Evasion'),
('nmap -sA 192.168.1.1', 'Performs an ACK scan to determine firewall rules.', 'Firewall Testing, Stealth Scan'),
('nmap --top-ports 20 192.168.1.1', 'Scans the top 20 most commonly used ports.', 'Quick Scan, Port Scanning'),
('nmap -sR 192.168.1.1', 'Scans for RPC services on the target.', 'Service Detection, RPC Scan'),
('nmap --script=http-enum 192.168.1.1', 'Enumerates web server directories and applications.', 'Web Scanning, Script Scan'),
('nmap --script=ftp-anon 192.168.1.1', 'Checks if the target FTP server allows anonymous login.', 'FTP Scan, Security Testing'),
('nmap --script=smb-os-discovery 192.168.1.1', 'Detects the target Windows OS using SMB protocol.', 'SMB Scan, OS Detection'),
('nmap -Pn 192.168.1.1', 'Skips host discovery and assumes the host is online.', 'Aggressive Scan, Firewall Evasion');


-- more commands too though::
INSERT INTO nmap_commands (command, description, category) VALUES
('nmap -T4 192.168.1.1', 'Uses timing template 4 for faster scans.', 'Performance Optimization'),
('nmap -T1 192.168.1.1', 'Uses timing template 1 for slower, stealthier scans.', 'Stealth Scan, Performance Optimization'),
('nmap -p 22 --open 192.168.1.1', 'Checks if SSH (port 22) is open on the target.', 'Port Scanning, SSH Scan'),
('nmap --script=ssl-cert 192.168.1.1', 'Retrieves SSL certificate information from HTTPS services.', 'SSL Scan, Security Testing'),
('nmap -sO 192.168.1.1', 'Performs an IP protocol scan to identify supported protocols.', 'IP Protocol Scan'),
('nmap -sL 192.168.1.0/24', 'Lists all IP addresses in a subnet without scanning them.', 'Network Discovery, Host Enumeration'),
('nmap -6 2001:db8::1', 'Performs an IPv6 scan on the target.', 'IPv6 Scanning'),
('nmap -sI zombie_host 192.168.1.1', 'Performs an idle scan using a zombie host.', 'Stealth Scan, Advanced Techniques'),
('nmap -sW 192.168.1.1', 'Performs a TCP window scan to check for open ports.', 'Stealth Scan, Port Scanning'),
('nmap --traceroute 192.168.1.1', 'Traces the network path to the target.', 'Network Discovery, Traceroute'),
('nmap -sT --reason 192.168.1.1', 'Performs a TCP connect scan and explains why a port is in a certain state.', 'Port Scanning, Connection Scan'),
('nmap --script=http-title 192.168.1.1', 'Gets the title of web pages hosted on the target.', 'Web Scanning, Information Gathering'),
('nmap -p 21 --script=ftp-vsftpd-backdoor 192.168.1.1', 'Checks if the FTP server is vulnerable to VSFTPD backdoor.', 'Security Testing, Vulnerability Scan'),
('nmap --script=smb-enum-shares 192.168.1.1', 'Lists shared folders on a Windows SMB server.', 'SMB Scan, Security Testing'),
('nmap -p 53 --script=dns-zone-transfer 192.168.1.1', 'Attempts a DNS zone transfer.', 'DNS Scan, Security Testing'),
('nmap --script=http-headers 192.168.1.1', 'Retrieves HTTP headers from the target web server.', 'Web Scanning, Information Gathering'),
('nmap -sM 192.168.1.1', 'Uses a TCP Maimon scan to bypass firewalls.', 'Stealth Scan, Firewall Evasion'),
('nmap --script=whois-domain 192.168.1.1', 'Performs a WHOIS lookup on a domain.', 'Information Gathering, DNS Scan'),
('nmap -p 23 --script=telnet-brute 192.168.1.1', 'Performs brute-force login attempts on Telnet.', 'Brute Force, Security Testing'),
('nmap -p 3389 --script=rdp-vuln-ms12-020 192.168.1.1', 'Checks if RDP is vulnerable to MS12-020.', 'Security Testing, Vulnerability Scan');

