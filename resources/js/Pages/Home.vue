<template>
    <n-layout :has-sider="!useDrawer">
        <!-- menu goes here -->
        <n-config-provider :theme="theme">
            <n-layout-sider
                v-if="!useDrawer"
                bordered
                collapse-mode="width"
                :collapsed-width="64"
                :width="240"
                :native-scrollbar="false"
                style="height: 100vh"
                :show-trigger="!useDrawer"
                :collapsed="menuCollapsed"
                @collapse="menuCollapsed = true"
                @expand="menuCollapsed = false"
            >
                <n-menu
                    :collapsed-width="64"
                    :collapsed-icon-size="22"
                    :options="menuOptions"
                    
                    :collapsed="menuCollapsed"
                />
            </n-layout-sider>
        
            <!-- otherwise? use drawer :) -->
            <n-drawer
                v-if="useDrawer"
                v-model:show="menuCollapsed"
                :width="240"
                placement="left"
            >
                <n-drawer-content
                    body-content-style="padding:0;"
                >
                    <!-- the menu on drawer. close drawer on select -->
                    <n-menu 
                        :options="menuOptions"
                        @update:value="handleMenuClick"
                        />
                </n-drawer-content>
            </n-drawer>
        </n-config-provider>

        <!-- content goes here -->
        <n-layout style="height: 100vh">
            
            <n-layout-header
                style="top: 0; position: sticky; z-index: 1;"
                bordered
            >
                <div style="display: flex; flex-direction: row; flex-wrap: nowrap; align-items: center;">
                    <!-- hamburger menu -->
                    <n-button
                        v-if="useDrawer"
                        @click="toggleMenu"
                        tertiary
                        style="margin: 0.5rem 1rem"
                    >
                        <Icon>
                            <MenuSharp />
                        </Icon>
                    </n-button>
                    <div style="flex-grow: 1; text-align: right;">
                        <n-popover 
                            trigger="click" 
                            placement="bottom-end"
                            style="padding: 0; margin-right: 0.5rem;"
                        >
                            <!-- the trigger -->
                            <template #trigger>
                                <div 
                                    style="padding: 0.5rem 1rem; display: inline-flex; justify-content: flex-end; align-items: center; cursor: pointer;"
                                    >
                                    <div style="font-weight: 400; margin-right: 0.5rem;">
                                        Bow Vernon
                                        <Icon>
                                            <ChevronDown/>
                                        </Icon>
                                    </div>
                                    <n-avatar 
                                        src="https://i.pravatar.cc/48"
                                        :size="32"
                                        round
                                    />
                                </div>
                            </template>
                            <!-- the content -->
                            <n-menu 
                                :options="userMenu"
                                :root-indent="12"
                                style="min-width: 160px;"
                                />
                        </n-popover>
                    </div>
                </div>
            </n-layout-header>

            <n-layout-content content-style="padding: 0.5rem 1.0rem">
                <n-p>Width: {{ width }}, Height: {{ height }}</n-p>
                <n-p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus augue at diam faucibus volutpat. Ut gravida lorem eu eros egestas, in euismod lorem finibus. Curabitur at justo ac tortor volutpat lobortis. Suspendisse dignissim urna at orci gravida sagittis. Nunc ac dictum felis. Sed mi dui, ullamcorper non lobortis vel, hendrerit a felis. Morbi massa risus, tempor at neque a, rutrum varius mauris. Pellentesque mattis massa in lectus pellentesque, eu imperdiet dolor vulputate. Aliquam erat volutpat. Quisque id lectus at nisi aliquam pulvinar. Mauris nisi nibh, fringilla vel elit a, auctor rutrum mauris. Suspendisse rutrum placerat sodales.</n-p>
                <n-p>Sed maximus consectetur est, et interdum lorem vestibulum id. Fusce quis convallis diam, nec consequat lorem. Nulla facilisi. Pellentesque placerat aliquam ipsum, vel aliquam odio venenatis quis. Donec aliquet velit sed nisi consectetur, at euismod tortor finibus. In neque arcu, vehicula et dolor non, consequat finibus dolor. Donec faucibus sem vitae aliquam fermentum. Donec cursus augue metus. Maecenas semper fermentum dui, vel sodales enim laoreet semper. In ut elementum velit. Donec ipsum massa, porttitor eget pretium quis, commodo eget massa. Aenean ante eros, efficitur ut est ut, aliquet accumsan magna. Donec commodo, enim pulvinar ultrices scelerisque, erat urna varius orci, vel posuere est eros eget quam. </n-p>
                <n-p> Curabitur eget nibh justo. Sed sit amet sapien urna. Donec lacinia velit ut urna ornare aliquam. Curabitur varius pellentesque tellus, sed sagittis dui tincidunt vitae. Fusce lacinia congue placerat. Aenean consectetur imperdiet urna, sit amet finibus lorem elementum a. Phasellus diam dui, feugiat sit amet erat nec, lobortis hendrerit lacus. Nullam sit amet eleifend dui. Integer nisi ipsum, consectetur nec turpis in, mattis dapibus turpis. Nulla nibh magna, rhoncus pharetra enim quis, mattis porta elit. Mauris nec mi et felis porttitor molestie id at felis. Integer metus nibh, eleifend quis risus nec, tincidunt ultrices sem. Donec at auctor sem. Ut feugiat tempus lacinia. Vestibulum eget iaculis lorem, sit amet tristique diam. Sed rutrum orci at nibh cursus viverra. </n-p>
                <n-p> Sed at orci ut purus faucibus ultrices. Donec aliquet justo non dictum porttitor. Suspendisse et eleifend augue, quis condimentum dolor. Donec ut sem ac enim imperdiet vehicula. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eget ligula aliquet, rutrum nisl vel, pharetra eros. Sed finibus urna non massa pulvinar semper. Fusce in velit commodo, elementum orci eu, volutpat est. Donec et arcu diam. Maecenas eleifend, tellus id porta elementum, quam risus hendrerit erat, eget molestie dolor urna eget odio. Nam sed leo pretium, dictum arcu sit amet, euismod mauris. Quisque eleifend aliquet neque. Phasellus neque nisi, aliquet in consectetur at, viverra sit amet quam. Morbi elementum nibh non neque lobortis, nec mattis nunc rutrum. Donec sagittis nibh in nibh finibus laoreet. </n-p>
                <n-p> Integer nulla eros, mollis vitae odio in, tincidunt volutpat nulla. Nulla mattis, eros sit amet ornare convallis, ante mi tempor lectus, quis finibus dui quam eget est. In sollicitudin ac nisi a iaculis. Praesent bibendum sollicitudin odio quis lobortis. Curabitur porttitor sem in turpis efficitur tincidunt sit amet non diam. Nunc in ante vel nunc aliquet tempor. Donec mollis ultrices elit at sodales. In dui neque, tincidunt feugiat lobortis at, sagittis a leo. Fusce sollicitudin dolor non augue rutrum mattis. Sed aliquet cursus velit sit amet facilisis. Etiam dictum pellentesque rhoncus. Aenean tincidunt faucibus cursus. Ut auctor lorem est, bibendum ornare neque efficitur quis. Morbi condimentum, nisl sed cursus sagittis, neque eros varius enim, pellentesque dignissim mi leo ac nisl. Aliquam maximus porttitor ante, nec tincidunt arcu pellentesque ac. Aenean rutrum purus nisl, a tempus est molestie ac. </n-p>
                <n-p> Ut eget velit arcu. Etiam pretium orci at nulla congue, et lacinia eros fringilla. Nulla iaculis pharetra aliquam. Cras pellentesque metus dui, eget pellentesque leo pulvinar et. Duis vestibulum dolor et nunc ornare, id pulvinar elit varius. Maecenas nec ornare dolor. Aenean condimentum eu lorem eu volutpat. Donec non efficitur felis. Phasellus lacinia auctor massa a luctus. Sed consectetur, tellus et gravida finibus, nunc diam consequat augue, vitae egestas purus nisl convallis quam. Phasellus sed consequat metus, eget laoreet ligula. Sed fringilla bibendum est, eu semper lacus consectetur dapibus. Curabitur nec pulvinar felis. Nulla rutrum sapien vitae mollis posuere. Proin auctor consequat eros pretium tincidunt. </n-p>
                <n-p> Vestibulum ullamcorper arcu at lacus molestie ullamcorper ac quis ex. Ut sit amet enim sit amet nunc efficitur porta in at elit. Phasellus molestie, mi quis aliquet aliquam, urna eros aliquet nisl, eu bibendum mauris massa ut orci. Nam placerat venenatis facilisis. Duis in sem libero. Cras sit amet ligula nulla. Mauris malesuada dictum rhoncus. Suspendisse facilisis lorem vel ligula commodo eleifend. Cras luctus nec est at efficitur. Praesent vestibulum fringilla diam vel suscipit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam eu faucibus quam. Vivamus quis nisl eu velit porttitor volutpat. Morbi neque dui, eleifend ac dui at, eleifend elementum libero. Maecenas pellentesque mattis sodales. Etiam fringilla turpis a ligula gravida, ac pulvinar urna sollicitudin. </n-p>
            </n-layout-content>
        </n-layout>
    </n-layout>
</template>

<script>
import { Link, Head } from "@inertiajs/inertia-vue3";
import { getUser } from "../Composables/api";
import { computed, h, onMounted, ref } from "vue";
import { renderIcon } from "../naiveui";
import {
    Bookmark,
    Download,
    ChevronDown,
    Rocket,
    Trash,
    MenuSharp,
    Power,
    IdCard,
} from "@vicons/ionicons5";
import { useScreen } from "../Composables/screen";
import { darkTheme } from 'naive-ui'

export default {
    components: {
        Link,
        Head,
        MenuSharp,
        ChevronDown
    },

    props: {
        title: String,
        contents: [Object, Array],
    },

    setup() {
        const userData = ref(null);
        const busy = ref(true);
        const theme = ref(darkTheme)

        console.log('Theme', darkTheme)

        onMounted(() => {
            console.log("Mounted at ", new Date().toString());
            getUser()
                .then((res) => {
                    userData.value = res.data;
                    busy.value = false;
                })
                .catch((e) => {
                    busy.value = false;
                });
        });

        // handlers
        const mailResult = (e) => {
            alert("Mail the result here...");
        };

        const archive = (e) => {
            alert("Do the archive here...");
        };

        const deleteResult = (id) => {
            if (confirm(`Yakin Mau hapus item #${id}?`)) {
                alert("Hapus di sini...");
            } else {
                alert("Ga jadi? payah...");
            }
        };

        const createMenuItem = (title, href, key, icon) => ({
            label: () =>
                h(
                    Link,
                    {
                        href: href,
                    },
                    {
                        default: () => title,
                    }
                ),
            key: key,
            icon: renderIcon(icon),
        });

        let menu = [
            {
                label: () =>
                    h(
                        Link,
                        {
                            href: `/article/2`,
                        },
                        { default: () => `Artikel #2` }
                    ),
                key: `article-2`,
                icon: renderIcon(Bookmark),
            },
            {
                label: () =>
                    h(
                        Link,
                        {
                            href: `/article/3`,
                        },
                        { default: () => `Artikel #3` }
                    ),
                key: `article-3`,
                icon: renderIcon(Bookmark),
            },
            {
                label: () =>
                    h(
                        Link,
                        {
                            href: `/article/4`,
                        },
                        { default: () => `Artikel #4` }
                    ),
                key: `article-4`,
                icon: renderIcon(Bookmark),
            },
        ];

        menu.push(
            createMenuItem("Article 42", "/article/42", "article-42", Rocket)
        );
        menu.push(
            createMenuItem("Article 44", "/article/44", "article-44", Trash)
        );
        menu.push(
            createMenuItem("Article 45", "/article/45", "article-45", Download)
        );

        let i = 0;
        while (i < 10) {
            menu.push(
                createMenuItem(
                    "Article " + i,
                    "/article/" + i,
                    "article-" + i,
                    Trash
                )
            );
            i++;
        }

        let userMenu = [
            {
                label: () => 
                    h(
                        'a',
                        {
                            href: 'https://intra.siroleg.xyz/'
                        },
                        { default: () => `Profile` }
                    )
                ,
                key: 'user-profile',
                icon: renderIcon(IdCard)
            },
            {
                key: 'divider-1',
                type: 'divider'
            },
            {
                label: () => 
                    h(
                        Link,
                        {
                            href: `/logout`,
                            method: 'post'
                        },
                        { default: () => `Logout` }
                    )
                ,
                key: 'user-logout',
                icon: renderIcon(Power)
            }
            
        ]


        // track screen size
        const { width, height } = useScreen();
        // menu collapsed state
        const menuCollapsed = ref(false);
        // do we use drawer?
        const useDrawer = computed(() => {
            return width.value <= 480;
        });
        // function to toggle menu
        const toggleMenu = () => {
            menuCollapsed.value = !menuCollapsed.value;
        };
        // handle menu click
        const handleMenuClick = (key, item) => {
            console.log('key', key)
            console.log('item', item)
            console.log('menuCollapse? ', menuCollapsed.value)
            // toggle drawer
            toggleMenu()
        }

        return {
            userData,
            busy,
            mailResult,
            archive,
            deleteResult,
            
            menuOptions: menu,
            userMenu,

            width,
            height,

            menuCollapsed,
            toggleMenu,
            handleMenuClick,

            useDrawer,

            theme,
        };
    },
};
</script>
