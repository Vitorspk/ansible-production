# Ansible Production Environment

A production-ready Ansible playbook for automated deployment of WordPress infrastructure with LEMP stack (Linux, Nginx, MySQL/MariaDB, PHP).

## Overview

This repository contains Ansible roles and playbooks for deploying a complete WordPress environment on CentOS/RedHat and Debian/Ubuntu systems. The automation handles system configuration, security hardening, and application deployment.

## Architecture

The infrastructure consists of:
- **Web Server**: Nginx with PHP-FPM for WordPress hosting
- **Database Server**: MariaDB/MySQL for WordPress data storage
- **Application**: WordPress CMS with automated configuration

## Prerequisites

- Ansible 2.9+ installed on control node
- SSH access to target servers
- Python installed on target hosts
- Vagrant (optional, for local testing)

## Directory Structure

```
ansible-production/
├── ansible.cfg           # Ansible configuration file
├── hosts                 # Inventory file with server definitions
├── playbook.yml         # Main playbook
├── group_vars/          # Group variables
├── roles/               # Ansible roles
│   ├── common/         # Base system configuration
│   ├── mysql/          # MariaDB/MySQL database setup
│   ├── nginx/          # Nginx web server configuration
│   ├── php/            # PHP-FPM setup and configuration
│   └── wordpress/      # WordPress installation and configuration
├── vagrant_centos_01/  # Vagrant configuration for CentOS testing
└── vagrant_ubuntu_01/  # Vagrant configuration for Ubuntu testing
```

## Roles Description

### Common Role
Handles base system configuration including:
- System profile customization (history, aliases)
- SELinux management (CentOS/RedHat)
- Package management and system updates
- EPEL repository installation
- User management (creates 'treinamento' user)
- Timezone configuration (America/Sao_Paulo)
- SSH configuration
- MOTD customization

### MySQL Role
Manages database server:
- MariaDB installation and configuration
- Root password management
- WordPress database creation
- WordPress database user setup
- Secure installation defaults

### Nginx Role
Web server configuration:
- Official Nginx repository setup
- Nginx installation from official repos
- Virtual host configuration
- Document root setup (/var/www/html)
- Performance optimization

### PHP Role
PHP-FPM environment:
- PHP 7.2 installation with extensions
- PHP-FPM configuration for Nginx
- Session and cache directory setup
- Timezone configuration
- Security hardening

### WordPress Role
WordPress deployment:
- Latest WordPress download and extraction
- wp-config.php generation with secure salts
- Database connection configuration
- File permissions setup

## Configuration

### Inventory Setup

Edit the `hosts` file to define your servers:

```ini
[servidores_web]
www ansible_ssh_host=192.168.33.10

[servidores_db]
mysql ansible_ssh_host=192.168.33.11

[servidores:children]
servidores_web
servidores_db
```

### Variables

Key variables can be customized in:
- `group_vars/` - Group-specific variables
- `roles/*/vars/main.yml` - Role-specific variables
- `roles/*/defaults/main.yml` - Default role variables

## Usage

### Basic Deployment

1. Clone the repository:
```bash
git clone https://github.com/yourusername/ansible-production.git
cd ansible-production
```

2. Update the inventory file with your server details:
```bash
vim hosts
```

3. Run the playbook:
```bash
ansible-playbook -i hosts playbook.yml
```

### Using with Vagrant

For local testing with Vagrant:

```bash
# For CentOS testing
cd vagrant_centos_01
vagrant up

# For Ubuntu testing
cd vagrant_ubuntu_01
vagrant up
```

### Running Specific Roles

To run only specific roles:

```bash
# Run only the common role
ansible-playbook -i hosts playbook.yml --tags common

# Run database setup only
ansible-playbook -i hosts playbook.yml --tags mysql
```

## Security Considerations

- SELinux is disabled on CentOS/RedHat systems
- Default MariaDB root password is set to 'mestre' (change in production)
- WordPress database password is set to 'wordpress' (change in production)
- SSH configuration can be customized in the common role
- Firewall rules should be configured based on your security requirements

## OS Support

Tested and supported on:
- CentOS 7
- RedHat Enterprise Linux 7
- Ubuntu 18.04/20.04
- Debian 9/10

## Customization

### Changing Database Credentials

Edit `roles/mysql/tasks/main.yml`:
- Line 27: Change root password
- Lines 53, 60: Update WordPress database credentials

### Modifying PHP Version

Edit `roles/php/tasks/main.yml`:
- Lines 6-10: Update repository URLs for different PHP version

### Nginx Configuration

Custom Nginx configurations can be added to `roles/nginx/files/`

## Troubleshooting

### Common Issues

1. **SSH Connection Issues**
   - Ensure SSH keys are properly configured
   - Check `ansible.cfg` for correct SSH settings

2. **Package Installation Failures**
   - Verify internet connectivity on target hosts
   - Check repository configurations

3. **Permission Errors**
   - Ensure sudo/become privileges are configured
   - Check `ansible.cfg` privilege escalation settings

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/improvement`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/improvement`)
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Author

Ansible Production Environment
Infrastructure as Code for WordPress Deployment

## Support

For issues, questions, or contributions, please open an issue in the GitHub repository.