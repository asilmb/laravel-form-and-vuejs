import AllProduct from './components/company/AllProduct.vue';
import CreateProduct from './components/company/CreateProduct.vue';
import EditProduct from './components/company/EditProduct.vue';

export const routes = [
  {
    name: 'home',
    path: '/',
    component: AllProduct
  },
  {
    name: 'create',
    path: '/create',
    component: CreateProduct
  },
  {
    name: 'edit',
    path: '/edit/:id',
    component: EditProduct
  }
];