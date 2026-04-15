import {getTranslations} from "./translations.js";

const isPro = Boolean(tsproduct_settings.is_pro);

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
        label: translations.dashboard,
        icon: ''
      },
      teamShowcase:{
        link: '?page=ts-product-showcase&path=showcase',
        label: translations.productShowcase,
        icon: ''
      },
      teamMember:{
        link: '?page=ts-product-showcase&path=team-member',
        label: translations.teamMember,
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
          //     link: '?page=ts-product-showcase&path=tools',
          //     label: translations.tools,
          // },
          ...(isPro && {
              account:{
                  link: 'admin.php?page=tsteam-pro-account',
                  label: translations.account,
              }
          }),
          supportForum:{
              link: 'https://wordpress.org/support/plugin/ts-product-showcase',
              label: translations.supportForum,
          },
      },
        ...(isPro ? {} : {
            proLink: {
                link: 'https://themespell.com/ts-product-showcase',
                label: translations.getPro,
            }
        }),
      version: '0.0.6',
    }
  };
  
export default globalSettings;  
