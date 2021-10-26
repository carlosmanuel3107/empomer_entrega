export default [
  {
    _name: 'CSidebarNav',
    _children: [
      {
        _name: 'CSidebarNavItem',
        name: 'Dashboard',
        to: '/dashboard',
        icon: 'cil-speedometer',
        badge: {
          color: 'primary',
          text: 'NEW'
        }
      },      
      {
        _name: 'CSidebarNavItem',
        name: 'Categorias',
        to: '/category/list',
        icon: 'cil-list',       
      },
      {
        _name: 'CSidebarNavItem',
        name: 'Ofrendas',
        to: '/gift/list',
        icon: 'cil-list',       
      },
      {
        _name: 'CSidebarNavItem',
        name: 'Post',
        to: '/post/list',
        icon: 'cil-list',       
      },
      {
        _name: 'CSidebarNavItem',
        name: 'Customer',
        to: '/customer/list',
        icon: 'cil-list',       
      }        
    ]
  }
]

