export interface NavLink {
  /**
   * @param {string} route path of screen which user will navigate to it.
   */
  route: string;

  /**
   * @param {string} title displayed label.
   */
  title: string;

   /**
   * @param {string} role required role.
   */
   permissionCategory?: string;
}

export let dashboardNavLinks: NavLink[] = [
  {
    route: '/dashboard/merchants',
    title: 'merchants',
    permissionCategory:"Merchants"

  },
  {
    route: '/dashboard/banks',
    title: 'all_banks',
    permissionCategory:"Banks Management"
  },
  {
    route: '/dashboard/transactions',
    title: 'reports',
    permissionCategory:"Reports"
  },
  {
    route: '/dashboard/statistics',
    title: 'statistics'
  },
  {
    route: '/dashboard/terminal-bank',
    title: 'terminal_bank',
    permissionCategory:"Terminal accounts"
  },
  {
    route: '/dashboard/transaction-to-do',
    title: 'settlement_files',
    permissionCategory:"Transaction to do"
  },
  {
    route: '/dashboard/customers',
    title: 'customers',
    permissionCategory:"Customers"
  },
  {
    route: '/dashboard/admins',
    title: 'dashboard_users_management',
     permissionCategory:"Super admin"
  },
  {
    route: '/dashboard/roles',
    title: 'dashboard_permissions_management',
     permissionCategory:"Super admin"
  },
  {
    route: '/dashboard/audit',
    title: 'Audit',
     permissionCategory:"Super admin"
  },
  {
    route: '/dashboard/working-days',
    title: 'Update Working Days',
    permissionCategory:"Working days"
  },
  // {
  //   route: '/dashboard/commission',
  //   title: 'Commission Scheme',
  //   permissionCategory:"Commission"
  // },
  {
    route: '/dashboard/settings',
    title: 'Settings',
    permissionCategory:"Settings"
  }
];
