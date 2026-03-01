# BakersHub Full Stack E-Commerce Platform

## Project Overview
BakersHub is a full-stack e-commerce platform designed specifically for bakeries. It provides a seamless online shopping experience for customers to browse and purchase baked goods from their favorite local bakeries. The application aims to enhance the customer experience by providing features such as product reviews, order tracking, and an easy-to-use interface.

## Tech Stack
- **Frontend:** React.js, Redux, Bootstrap
- **Backend:** Node.js, Express.js
- **Database:** MongoDB
- **Payment Processing:** Stripe API
- **Deployment:** Heroku

## Features
- User registration and authentication
- Browse products with advanced filtering options
- Review products and bakeries
- Shopping cart functionality
- Secure payment processing
- Order management and tracking
- Admin dashboard for managing products and orders

## Setup Instructions
1. **Clone the repository:**  
   ```bash
   git clone https://github.com/jarvishiv62/BakersHub-Full-Stack-E-commerce-Platform.git
   cd BakersHub-Full-Stack-E-commerce-Platform
   ```
2. **Install dependencies:**  
   For the backend, run:
   ```bash
   cd server
   npm install
   ```  
   For the frontend, run:
   ```bash
   cd client
   npm install
   ```
3. **Set up environment variables:**  
   Create a `.env` file in the `server` directory and add your environment variables for the database and Stripe API key.
4. **Run the application:**  
   For the backend, run:
   ```bash
   cd server
   npm start
   ```  
   For the frontend, open a new terminal and run:
   ```bash
   cd client
   npm start
   ```

## Contributing
We welcome contributions! Please fork the repository and submit a pull request for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
