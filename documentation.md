# SwiftQ Documentation

## Table of Contents
1. [Overview](#overview)
2. [Project Structure](#project-structure)
3. [Backend Architecture](#backend-architecture)
4. [Configuration](#configuration)
5. [Authentication](#authentication)

---

## Overview

This documentation provides a comprehensive guide to the SwiftQ project, including all backend logic, processes, and system architecture.

---

## Project Structure

```
SwiftQ/
├── Admin/
├── Backend/
│   └── config.php
├── Public/
│   ├── assets/
│   │   ├── images/
│   │   ├── js/
│   │   │   ├── register.js
│   │   │   ├── router.js
│   │   │   └── swiper.js
│   │   └── style/
│   │       ├── output.css
│   │       └── tailwind.css
│   ├── auth/
│   │   └── company-registration.html
│   └── components/
├── documentation.md
├── index.html
├── LICENSE
├── package.json
└── README.md
```

---

## Backend Architecture

### Core Configuration

The backend infrastructure is initialized through the **config.php** file, which serves as the central configuration hub for all backend operations and database connections.

---

## Configuration

### Setup

- Backend configuration file: `Backend/config.php`
- The configuration module establishes all necessary database connections and loads core backend utilities

---

## Authentication

### Overview

The authentication system handles company registration and user sign-up processes.

### Components

- **Company Registration**: Located in `Public/auth/company-registration.html`
- **Registration Handler**: `Public/assets/js/register.js`
- **Backend Implementation**: Managed in the `Backend/` folder

### Features

- Company registration flow
- User sign-up functionality
- Credential management

---

## Additional Resources

- [README](README.md) - Project overview
- [LICENSE](LICENSE) - License information