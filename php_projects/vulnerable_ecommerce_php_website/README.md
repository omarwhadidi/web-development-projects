<h1 align="center"> Vulnerable Ecommerce web application  </h1>

This is a Vulnerable Dockerized Ecommerce web application Written in Native OOP PHP For Testing Purpose.  Also I have used docker container and docker-compose to build && manage multiple container together 

# [+] Installation :

 - Docker-compose up --build -d
 
# [+] Usage :

 - Web App => localhost:8000/
 - PHPmyadmin => localhost:8001/
 
 
 # [+] Vulnerabilities To Test :
 
 - Auth
   - Email Enumeration via Response 
   - Password Reset Poisoning 
 - Session Managment
   - Session Fixation 
   - cookie missing httponly/secure flags
  - Access Control
   - Execution After Remediation in Admin Page
   - IDOR on Generating Order PDFs
 - User Vulnerabilities
   - XSS
     - SELF XSS
     - Blind XSS
     - Stored XSS
     - Reflected XSS
     - Stored XSS in SVG File Upload 
   - CSRF
     - Bad Regex Check in Referer Header
   - Open redirect 
  - Database Vulnerabilities
    - SQL Injection 
  - Web App Vulnerabilities
    - Unrestricted File Upload (XSS Via File Upload / XSS in Filename )
    - Insecure deserialization *

