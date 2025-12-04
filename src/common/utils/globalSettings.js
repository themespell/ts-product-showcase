import {getTranslations} from "./translations.js";

const isPro = !!tsproduct_settings.is_pro ?? false;

const translations = getTranslations();

const globalSettings = {
    token: {
        colorPrimary: '#FE4F0A',
        colorBgContainer: '#fff',
        colorText: '#000000',
    },
    components: {
      Table: {
        "headerBg": "#FFEDE6",
        "headerColor": "#111C5C",
        "headerBorderRadius": 15,
        "borderRadius": 15,
        "boxShadowSecondary": 0
      },
      Input: {
        "colorBorder": "#C1DAF8",
        "borderRadius": 12,
        "paddingBlock": 6,
        "paddingBlockLG": 8
      },
    },
    theme: {
      primaryColor: '#FE4F0A',
      textColor: '#333',
      borderColor: '#ededed',
      borderColorLight: '#DFD5F6'
    },
    navigation: {
      dashboard:{
        link: '?page=ts-product-showcase&path=dashboard',
        label: 'Dashboard',
        icon: ''
      },
      teamShowcase:{
        link: '?page=tsteam-showcase',
        label: 'Team Showcase',
        icon: ''
      },
      teamMember:{
        link: '?page=tsteam-showcase&path=team-member',
        label: 'Team Member',
        icon: ''
      },
    },
    topbar: {
      menuitems: {
          dashboard:{
              link: '?page=ts-product-showcase&path=dashboard',
              label: translations.dashboard,
          },
          productShowcase:{
              link: '?page=ts-product-showcase&path=showcase',
              label: translations.productShowcase,
          },
          // tools:{
          //     link: '?page=tsteam-showcase&path=tools',
          //     label: translations.tools,
          // },
          ...(isPro && {
              account:{
                  link: 'admin.php?page=tsteam-pro-account',
                  label: translations.account,
              }
          }),
          supportForum:{
              link: 'https://wordpress.org/support/plugin/ts-team-member',
              label: translations.supportForum,
          },
      },
        ...(isPro ? {} : {
            proLink: {
                link: 'https://themespell.com/ts-product/ts-team-member/',
                label: translations.getPro,
            }
        }),
      version: '0.0.5',
    }
  };
  
export default globalSettings;  