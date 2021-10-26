import Vue from 'vue'
import Router from 'vue-router'

// Containers
const TheContainerIndex = () => import('@/containers/index/TheContainer')
const TheContainer = () => import('@/containers/TheContainer')

// Views

//empomer
const Category_list = () => import('@/views/category/List')
const Gift_list = () => import('@/views/gift/List')
const Customer_list = () => import('@/views/customer/List')
const Customer_create = () => import('@/views/customer/Create')
const Customer_edit = () => import('@/views/customer/Edit')
const Post_list = () => import('@/views/post/List')


const Index = () => import('@/views/Index')

const Dashboard = () => import('@/views/Dashboard')

const Colors = () => import('@/views/theme/Colors')
const Typography = () => import('@/views/theme/Typography')

const Charts = () => import('@/views/charts/Charts')
const Widgets = () => import('@/views/widgets/Widgets')

// Views - Components
const HomeIndex = () => import('@/views/index/Contact')
const PublicationsIndex = () => import('@/views/index/Publications')


const Cards = () => import('@/views/base/Cards')
const Forms = () => import('@/views/base/Forms')
const Switches = () => import('@/views/base/Switches')
const Tables = () => import('@/views/base/Tables')
const Tabs = () => import('@/views/base/Tabs')
const Breadcrumbs = () => import('@/views/base/Breadcrumbs')
const Carousels = () => import('@/views/base/Carousels')
const Collapses = () => import('@/views/base/Collapses')
const Jumbotrons = () => import('@/views/base/Jumbotrons')
const ListGroups = () => import('@/views/base/ListGroups')
const Navs = () => import('@/views/base/Navs')
const Navbars = () => import('@/views/base/Navbars')
const Paginations = () => import('@/views/base/Paginations')
const Popovers = () => import('@/views/base/Popovers')
const ProgressBars = () => import('@/views/base/ProgressBars')
const Tooltips = () => import('@/views/base/Tooltips')

// Views - Buttons
const StandardButtons = () => import('@/views/buttons/StandardButtons')
const ButtonGroups = () => import('@/views/buttons/ButtonGroups')
const Dropdowns = () => import('@/views/buttons/Dropdowns')
const BrandButtons = () => import('@/views/buttons/BrandButtons')

// Views - Icons
const CoreUIIcons = () => import('@/views/icons/CoreUIIcons')
const Brands = () => import('@/views/icons/Brands')
const Flags = () => import('@/views/icons/Flags')

// Views - Notifications
const Alerts = () => import('@/views/notifications/Alerts')
const Badges = () => import('@/views/notifications/Badges')
const Modals = () => import('@/views/notifications/Modals')

// Views - Pages
const Page404 = () => import('@/views/pages/Page404')
const Page500 = () => import('@/views/pages/Page500')
const Login = () => import('@/views/pages/Login')
const Register = () => import('@/views/pages/Register')

// Users
const Users = () => import('@/views/users/Users')
const User = () => import('@/views/users/User')
const EditUser = () => import('@/views/users/EditUser')

//Notes
const Notes = () => import('@/views/notes/Notes')
const Note = () => import('@/views/notes/Note')
const EditNote = () => import('@/views/notes/EditNote')
const CreateNote = () => import('@/views/notes/CreateNote')

//Roles
const Roles = () => import('@/views/roles/Roles')
const Role = () => import('@/views/roles/Role')
const EditRole = () => import('@/views/roles/EditRole')
const CreateRole = () => import('@/views/roles/CreateRole')

//Bread
const Breads = () => import('@/views/bread/Breads')
const Bread = () => import('@/views/bread/Bread')
const EditBread = () => import('@/views/bread/EditBread')
const CreateBread = () => import('@/views/bread/CreateBread')
const DeleteBread = () => import('@/views/bread/DeleteBread')

//Resources
const Resources = () => import('@/views/resources/Resources')
const CreateResource = () => import('@/views/resources/CreateResources')
const Resource = () => import('@/views/resources/Resource')
const EditResource = () => import('@/views/resources/EditResource')
const DeleteResource = () => import('@/views/resources/DeleteResource')

//Email
const Emails        = () => import('@/views/email/Emails')
const CreateEmail   = () => import('@/views/email/CreateEmail')
const EditEmail     = () => import('@/views/email/EditEmail')
const ShowEmail     = () => import('@/views/email/ShowEmail')
const SendEmail     = () => import('@/views/email/SendEmail')

const Menus       = () => import('@/views/menu/MenuIndex')
const CreateMenu  = () => import('@/views/menu/CreateMenu')
const EditMenu    = () => import('@/views/menu/EditMenu')
const DeleteMenu  = () => import('@/views/menu/DeleteMenu')

const MenuElements = () => import('@/views/menuElements/ElementsIndex')
const CreateMenuElement = () => import('@/views/menuElements/CreateMenuElement')
const EditMenuElement = () => import('@/views/menuElements/EditMenuElement')
const ShowMenuElement = () => import('@/views/menuElements/ShowMenuElement')
const DeleteMenuElement = () => import('@/views/menuElements/DeleteMenuElement')

const Media = () => import('@/views/media/Media')


Vue.use(Router)

let router = new Router({
  mode: 'hash', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
})


router.beforeEach((to, from, next) => {
  let roles = localStorage.getItem("roles");
  if(roles != null){
    roles = roles.split(',')
  }
  if(to.matched.some(record => record.meta.requiresAdmin)) {
    if(roles != null && roles.indexOf('admin') >= 0 ){
      next()
    }else{
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    }
  }else if(to.matched.some(record => record.meta.requiresUser)) {
    if(roles != null && roles.indexOf('user') >= 0 ){
      next()
    }else{
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    }
  }else{
    next()
  }
})

export default router

function configRoutes () {
  return [
    {
      path: '/',
      redirect: '/index',
      name: '_Idex',
      component: TheContainerIndex,
      children: [
        {
          path: 'index',
          name: 'Index',
          component: Index
        },        
        {
          path: 'index',
          redirect: '/index/contact',
          name: '_Contact',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'contact',
              name: 'Contact',
              component: HomeIndex
            }
          ]
        },        
        {
          path: 'index',
          redirect: '/index/publications',
          name: '_Publications',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'publications',
              name: 'Publications',
              component: PublicationsIndex
            }
          ]
        }
      ]
    },
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Home',
      component: TheContainer,
      meta:{
        requiresUser: true
      },
      children: [       
        {
          path: 'dashboard',
          name: 'Empomer',
          component: Dashboard
        },              
        {
          path: 'category',
          redirect: '/category/list',
          name: 'Category',          
          component: {
            render (c) { return c('router-view') }
          },
          meta:{
            requiresAdmin: true
          },
          children: [
            {
              path: 'list',
              name: 'Category list',
              component: Category_list
            }          
          ]
        },
        {
          path: 'gift',
          redirect: '/gift/list',
          name: 'Gift',          
          component: {
            render (c) { return c('router-view') }
          },
          meta:{
            requiresAdmin: true
          },
          children: [
            {
              path: 'list',
              name: 'Gift list',
              component: Gift_list,                            
            }           
          ]
        },        
        {
          path: 'post',
          redirect: '/post/list',
          name: 'Post',          
          component: {
            render (c) { return c('router-view') }
          },
          meta:{
            requiresAdmin: true
          },
          children: [
            {
              path: 'list',
              name: 'Post list',
              component: Post_list,         
            }
            // {
            //   path: 'edit/:id',
            //   name: 'Category edit',
            //   component: Category_edit
            // },
            // {
            //   path: 'create',
            //   name: 'Category create',
            //   component: Category_create
            // }
          ]
        },
        {
          path: 'customer',
          redirect: '/customer/list',
          name: 'Custom',          
          component: {
            render (c) { return c('router-view') }
          },
          meta:{
            requiresAdmin: true
          },
          children: [
            {
              path: 'list',
              name: 'Customer list',
              component: Customer_list,
              meta:{
                requiresUser: true
              }
            },
            {
              path: 'edit/:id',
              name: 'Customer edit',
              component: Customer_edit
            },
            {
              path: 'create',
              name: 'Customer create',
              component: Customer_create
            }
          ]
        }       
      ]
    },
    {
      path: '/pages',
      redirect: '/pages/404',
      name: 'Pages',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '404',
          name: 'Page404',
          component: Page404
        },
        {
          path: '500',
          name: 'Page500',
          component: Page500
        },
      ]
    },
    {
      path: '/',
      redirect: '/login',
      name: 'Auth',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: 'login',
          name: 'Login',
          component: Login
        },
        {
          path: 'register',
          name: 'Register',
          component: Register
        },
      ]
    },
    {
      path: '*',
      name: '404',
      component: Page404
    }
  ]
}
