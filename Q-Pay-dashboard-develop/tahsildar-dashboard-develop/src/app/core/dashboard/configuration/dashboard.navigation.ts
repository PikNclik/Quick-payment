export interface NavLink {
  /**
   * @param {string} route path of screen which user will navigate to it.
   */
  route: string;

  /**
   * @param {string} title displayed label.
   */
  title: string;
}

export let dashboardNavLinks: NavLink[] = [
  {
    route: '/dashboard/merchants',
    title: 'Merchants',
  },
  {
    route: '/dashboard/banks',
    title: 'banks',
  },
  {
    route: '/dashboard/transactions',
    title: 'transactions'
  },
  {
    route: '/dashboard/statistics',
    title: 'statistics'
  }
];
