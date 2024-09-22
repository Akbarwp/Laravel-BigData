# Laravel Big Data

Laravel Big Data is a website designed for sentiment analysis on reviews of the PLN Mobile application. With features like Vectorizer and Confusion Matrix, this site enables users to understand and analyze user sentiments towards the application through structured data. The interactive interface and advanced analysis tools assist users in evaluating the quality of reviews and accurately identifying sentiment trends. The data used was obtained from the Kaggle website related to user reviews of the PLN Mobile application on Google Play. The data used can be accessed at the following link [Kaggle PLN Mobile](https://www.kaggle.com/code/rizkia14/analisis-sentimen-unsupervised-lexical/input?select=review-pln-mobile.csv)

## Tech Stack

- **Laravel 9**
- **MySQL Database**
- **[sastrawi/sastrawi](https://github.com/sastrawi/sastrawi)**
- **[maatwebsite/excel](https://laravel-excel.com/)**
- **[voku/stop-words](https://github.com/voku/stop-words)**
- **TailwindCSS**
- **daisyUI**

## Features

- Main features available in this application:
  - Sentiment Analysis
  - Vectorizer
  - Confusion Matrix

## Installation

Follow the steps below to clone and run the project in your local environment:

1. Clone repository:

    ```bash
    git clone https://github.com/Akbarwp/Laravel-BigData.git
    ```

2. Install dependencies use Composer and NPM:

    ```bash
    composer install
    npm install
    ```

3. Copy file `.env.example` to `.env`:

    ```bash
    cp .env.example .env
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Setup database in the `.env` file:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_bigdata
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. Run migration database:

    ```bash
    php artisan migrate
    ```

7. Run website:

    ```bash
    npm run dev
    php artisan serve
    ```

## Screenshot

- ### **Dashboard**

<img src="https://github.com/user-attachments/assets/45dec2dc-de67-4c05-aa6e-e28ff931b745" alt="Halaman Dashboard" width="" />
<br><br>

- ### **Resource page**

<img src="https://github.com/user-attachments/assets/62729c23-fe5b-49bc-896f-7a88b7faaf65" alt="Halaman Resource" width="" />
<br><br>

- ### **Prepocessing page**

<img src="https://github.com/user-attachments/assets/2519db4a-2ac6-480c-972c-96d30f3c7d0d" alt="Halaman Prepocessing" width="" />
<br><br>

- ### **Sentiment Analysis page**

<img src="https://github.com/user-attachments/assets/2e7dfeb4-2e0c-474d-a9c4-c04e7c52b869" alt="Halaman Sentiment Analysis" width="" />
<br><br>

- ### **Vectorizer page**

<img src="https://github.com/user-attachments/assets/7707d7ac-b73f-42ea-bf32-132014b4303d" alt="Halaman Vectorizer" width="" />
<br><br>

- ### **Confusion Matrix page**

<img src="https://github.com/user-attachments/assets/9b4dff0a-36d4-4274-9129-4c56ee7980ae" alt="Halaman Confusion Matrix" width="" />
<br><br>
