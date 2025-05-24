# FusionEats: Distributed Food Ordering System

## 📽️ Demo Video

[Click to watch the demo](https://drive.google.com/file/d/1qCXXxXIV5vv6X2CYVHQGwRd456Db_13P/view) <!-- Replace with your actual video link or GitHub hosted file path -->

## 🚀 Project Overview

**FusionEats** is an innovative, distributed food ordering platform that integrates real-time data from **three geographically distributed restaurant databases**. Developed with a focus on scalability, accuracy, and usability, FusionEats provides users with a seamless interface to explore **200-300 food options** with live availability.

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3
- **Backend:** PHP
- **Database:** MySQL
- **Security:** MD5 password hashing
- **Entity Matching Algorithms:** Jaro-Winkler, Levenshtein, Soundex

## ✨ Key Features

- 🔗 **IP-Based Database Connections:** Utilizes `mysqli_connect` to establish secure, efficient connections between PHP and distributed MySQL instances.
- 🔍 **Advanced Entity Matching:** Implements a fused model combining **Jaro-Winkler**, **Levenshtein**, and **Soundex** algorithms to ensure high-accuracy food item matching across different restaurant sources.
- 🔐 **Password Security:** User credentials are securely hashed using the MD5 hashing algorithm.
- 📊 **Admin Panel Functionalities:**
  - Add/Edit/Delete menu items (CRUD operations)
  - Monitor order activity
  - Analyze revenue reports

## 🧠 Why FusionEats?

FusionEats addresses the challenge of **integrating diverse restaurant offerings** under a unified, user-centric platform. The project demonstrates the power of **distributed databases**, **real-time data access**, and **custom algorithmic data matching**, making it a solid foundation for scalable food delivery systems.

## 📂 Folder Structure

```
FusionEats/
├── admin/                  # Admin panel related files
├── config/                 # Configuration files (e.g., database connection)
├── css/                    # Stylesheets
├── images/                 # Image assets
├── partials-front/         # Reusable frontend components
├── categories.php          # Page showing food categories
├── category-foods.php      # Displays foods under a selected category
├── food-search.php         # Search functionality for food items
├── foods.php               # Displays list of all foods
├── FusionEats.mp4          # Demo video file
├── index.php               # Homepage of the project
├── order.php               # Handles order placement

```
