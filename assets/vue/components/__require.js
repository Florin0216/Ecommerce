import app from "../instance";
import Navbar from "./UI/Navbar.vue";
import Registration from "./User/Registration.vue";
import Sidebar from "./UI/Sidebar.vue";
import ProductListAdmin from "./Product/admin/ProductListAdmin.vue";
import Login from "./User/Login.vue";
import CategoriesListAdmin from "./Category/admin/CategoriesListAdmin.vue";
import ProductListing from "./Product/ProductListing.vue";
import ProductShow from "./Product/ProductShow.vue";

app.component('navbar',Navbar);
app.component('sidebar',Sidebar);
app.component('login',Login);
app.component('registration', Registration);
app.component('product-list-admin', ProductListAdmin);
app.component('categories-list-admin',CategoriesListAdmin);
app.component('product-listing', ProductListing);
app.component('product-show', ProductShow);
