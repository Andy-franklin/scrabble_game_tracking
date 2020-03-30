<template>
    <a-layout class="layout">
        <a-layout-sider :trigger="null" collapsible v-model="collapsed"  class="layout__slider">
            <a-menu theme="dark" mode="inline" :defaultSelectedKeys="[navKey]">
                <a-menu-item key="1" @click="changeToMembers()">
                    <a-icon type="team" />
                    <span>Members</span>
                </a-menu-item>
                <a-menu-item key="2" @click="changeToGames()">
                    <a-icon type="smile" />
                    <span>Games</span>
                </a-menu-item>
            </a-menu>
        </a-layout-sider>
        <a-layout>
            <a-layout-header style="background: #fff; padding: 0">
                <div>
                    <a-icon
                        class="trigger"
                        :type="collapsed ? 'menu-unfold' : 'menu-fold'"
                        @click="()=> collapsed = !collapsed"
                    />
                    <slot name="header"></slot>
                </div>
            </a-layout-header>
            <a-layout-content
                :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '280px' }"
            >
                <slot name="content"></slot>
            </a-layout-content>
        </a-layout>
    </a-layout>
</template>
<script>
    import Vue from 'vue';
    import { Layout } from 'ant-design-vue';
    Vue.use(Layout);

    export default {
        props: {
            navKey: String
        },
        data() {
            return {
                collapsed: false
            };
        },
        methods: {
            changeToMembers() {
                window.location.replace('/admin/members');
            },
            changeToGames() {
                window.location.replace('/admin/games');
            }
        }
    };
</script>
<style lang="scss">
    .layout {
        height: 100%;

        &__slider {
            padding-top: 30px;
        }
    }

    .trigger {
        font-size: 18px;
        padding: 24px;
    }
</style>
