// Categories data
const categories = [
  { id: 1, name: "electronics", displayName: "Electronics" },
  { id: 2, name: "fashion", displayName: "Fashion" },
  { id: 3, name: "home", displayName: "Home & Living" },
  { id: 4, name: "sports", displayName: "Sports" },
];

// Sample product data
const products = [
  {
    id: 1,
    name: "Premium Wireless Headphones",
    category_id: 1,
    category: "electronics",
    price: 299.99,
    disc_price: 249.99,
    image: "/public/wireless-headphones.jpg",
    description:
      "High-quality wireless headphones with active noise cancellation and premium sound quality. Perfect for music lovers and professionals.",
    rating: 4.5,
    reviews: 128,
  },
  {
    id: 2,
    name: "Smart Watch Pro",
    category_id: 1,
    category: "electronics",
    price: 399.99,
    disc_price: 0,
    image: "/public/smart-watch.jpg",
    description:
      "Advanced smartwatch with health tracking, GPS, and seamless smartphone integration. Stay connected and healthy.",
    rating: 4.8,
    reviews: 256,
  },
  {
    id: 3,
    name: "Designer Leather Jacket",
    category_id: 2,
    category: "fashion",
    price: 249.99,
    disc_price: 199.99,
    image: "/public/leather-jacket.jpg",
    description:
      "Premium leather jacket with modern design. Crafted from genuine leather for durability and style.",
    rating: 4.6,
    reviews: 89,
  },
  {
    id: 4,
    name: "Ergonomic Office Chair",
    category_id: 3,
    category: "home",
    price: 349.99,
    disc_price: 0,
    image: "/public/office-chair.jpg",
    description:
      "Comfortable ergonomic chair designed for long working hours. Adjustable height and lumbar support.",
    rating: 4.7,
    reviews: 167,
  },
  {
    id: 5,
    name: "Professional Camera",
    category_id: 1,
    category: "electronics",
    price: 1299.99,
    disc_price: 0,
    image: "/public/professional-camera.jpg",
    description:
      "High-resolution professional camera with advanced features for photography enthusiasts and professionals.",
    rating: 4.9,
    reviews: 342,
  },
  {
    id: 6,
    name: "Running Shoes",
    category_id: 4,
    category: "sports",
    price: 129.99,
    disc_price: 99.99,
    image: "/public/running-shoes.jpg",
    description:
      "Lightweight running shoes with superior cushioning and support. Perfect for daily runs and marathons.",
    rating: 4.4,
    reviews: 203,
  },
  {
    id: 7,
    name: "Minimalist Backpack",
    category_id: 2,
    category: "fashion",
    price: 89.99,
    disc_price: 0,
    image: "/public/minimalist-backpack.jpg",
    description:
      "Sleek and functional backpack with multiple compartments. Ideal for work, travel, and everyday use.",
    rating: 4.5,
    reviews: 145,
  },
  {
    id: 8,
    name: "Coffee Maker Deluxe",
    category_id: 3,
    category: "home",
    price: 179.99,
    disc_price: 149.99,
    image: "/public/coffee-maker.jpg",
    description:
      "Premium coffee maker with programmable settings. Brew the perfect cup every morning.",
    rating: 4.6,
    reviews: 198,
  },
];

// Generate star rating - needed for Alpine templates
function generateStars(rating) {
  const fullStars = Math.floor(rating);
  const hasHalfStar = rating % 1 !== 0;
  let stars = "";

  for (let i = 0; i < fullStars; i++) {
    stars += '<i class="fas fa-star"></i>';
  }

  if (hasHalfStar) {
    stars += '<i class="fas fa-star-half-alt"></i>';
  }

  const emptyStars = 5 - Math.ceil(rating);
  for (let i = 0; i < emptyStars; i++) {
    stars += '<i class="far fa-star"></i>';
  }

  return stars;
}

// Add to cart function
function addToCart(productId) {
  alert(`Product ${productId} added to cart!`);
}

// Get product by ID
function getProductById(id) {
  return products.find((p) => p.id === Number.parseInt(id));
}

// For Alpine.js compatibility
const alpineProducts = [...products];
const alpineCategories = [...categories];

// Get category name by ID
function getCategoryNameById(id) {
  const category = categories.find((cat) => cat.id === id);
  return category ? category.displayName : "Unknown";
}
