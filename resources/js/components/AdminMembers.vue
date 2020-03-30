<template>
    <div>
        <the-layout navKey="1">
            <template v-slot:header>Members</template>
            <template v-slot:content>
                <a-button type="primary" class="button" @click="openModal('add')">Add Member</a-button>
                <a-table :columns="columns" :dataSource="data">
                    <span slot="action" slot-scope="text, record">
                        <a href="#" @click="view(text['key'])">View</a>
                        <a-divider type="vertical" />
                        <a href="#" @click="edit(text['key'])">Edit</a>
                        <a-divider type="vertical" />
                        <a href="#" @click="error('Sorry. This is still todo')">Delete</a>
                    </span>
                </a-table>
            </template>
        </the-layout>
        <a-modal title="Add Member" v-model="modalsDisplay.add" @canel="closeModal('add')" @ok="add()">
            <a-form :form="forms.add.form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }">
                <a-form-item label="Name">
                    <a-input v-model="forms.add.name"/>
                </a-form-item>
                <a-form-item label="Bio">
                    <a-textarea placeholder="Members bio" :rows="4" v-model="forms.add.bio"/>
                </a-form-item>
                <a-form-item label="Email">
                    <a-input v-model="forms.add.email"/>
                </a-form-item>
                <a-form-item label="Phone Number">
                    <a-input v-model="forms.add.phoneNumber"/>
                </a-form-item>
            </a-form>
        </a-modal>
        <a-modal title="Edit Member" v-model="modalsDisplay.edit" @canel="closeModal('edit')" @ok="update(forms.edit.id)">
            <a-form :form="forms.edit.form" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }">
                <a-form-item label="Name">
                    <a-input v-model="forms.edit.name"/>
                </a-form-item>
                <a-form-item label="Bio">
                    <a-textarea placeholder="Members bio" :rows="4" v-model="forms.edit.bio"/>
                </a-form-item>
                <a-form-item label="Email">
                    <a-input v-model="forms.edit.email"/>
                </a-form-item>
                <a-form-item label="Phone Number">
                    <a-input v-model="forms.edit.phoneNumber"/>
                </a-form-item>
            </a-form>
        </a-modal>
    </div>
</template>

<script>
    import axios from 'axios';
    import Vue from 'vue';
    import { Table, Modal } from 'ant-design-vue';
    Vue.use(Table);
    Vue.use(Modal);

    import TheLayout from "./layout/TheLayout";

    const columns = [
        {
            title: 'Name',
            dataIndex: 'name',
            key: 'name'
        },
        {
            title: 'Join Date',
            dataIndex: 'joinDate',
            key: 'joinDate',
        },
        {
            title: 'Games Played',
            dataIndex: 'gamesCount',
            key: 'gamesCount',
        },
        {
            title: 'Action',
            key: 'action',
            scopedSlots: { customRender: 'action' },
        },
    ];

    export default {
        data() {
            return {
                data: [],
                columns,
                modalsDisplay: {
                    add: false,
                    edit: false,
                },
                forms: {
                    add: {
                        form: this.$form.createForm(this),
                        name: '',
                        bio: '',
                        email: '',
                        phoneNumber: '',
                    },
                    edit: {
                        form: this.$form.createForm(this),
                        id: 0,
                        name: '',
                        bio: '',
                        email: '',
                        phoneNumber: '',
                    }
                }
            };
        },
        methods: {
            closeModal(key) {
                this.modalsDisplay[key] = false;
            },
            openModal(key) {
                this.modalsDisplay[key] = true;
            },
            submitForm(endpoint, formkey, method) {
                //Todo: Validate user response on JS
                let data = {
                    'name': this.forms[formkey].name,
                    'bio': this.forms[formkey].bio,
                    'email': this.forms[formkey].email,
                    'phone_number': this.forms[formkey].phoneNumber
                };

                //Todo: a loading state
                axios[method](endpoint, data).then((response) => {
                    let newData = {
                        key: response.data.data.id,
                        name: response.data.data.attributes.name,
                        joinDate: (new Date(response.data.data.attributes.created_at)).toLocaleString(),
                        gamesCount: parseInt(response.data.data.attributes.wins) + parseInt(response.data.data.attributes.losses),
                    };

                    if (formkey === 'edit') {
                        for (let i = 0; i < this.data.length; i++) {
                            if (response.data.data.id === this.data[i].key) {
                                this.data[i] = newData;
                                //Todo: Rerender the table row so that this update shows
                            }
                        }

                    } else {
                        this.data.push(newData);
                    }

                    this.success();

                    //Reset the form
                    this.forms[formkey].name = '';
                    this.forms[formkey].bio = '';
                    this.forms[formkey].email = '';
                    this.forms[formkey].phoneNumber = '';

                    this.closeModal(formkey);
                }).catch((error) => {
                    if (error.response.data.errors === undefined) {
                        this.error();
                        return;
                    }

                    let errorMessage = '';
                    Object.keys(error.response.data.errors).map(function(key, index) {
                        errorMessage += '\n' + key + ':';
                        error.response.data.errors[key].map(function(message, order) {
                            errorMessage += '\n' + message;
                        })
                    });

                    //Todo: a nicer html error rather than a popup
                    this.error(errorMessage);
                });
            },
            add() {
                this.submitForm('/api/member', 'add', 'post');
            },
            edit(memberId) {
                console.log(memberId);

                //Preset the data
                for (let i = 0; i < this.data.length; i++) {
                    if (memberId === this.data[i].key) {
                        this.forms.edit.name = this.data[i].name;
                        this.forms.edit.bio = this.data[i].bio;
                        this.forms.edit.email = this.data[i].email;
                        this.forms.edit.phoneNumber = this.data[i].phoneNumber;
                        this.forms.edit.id = memberId;
                        break;
                    }
                }

                //and then display the form
                this.openModal('edit');
            },
            update(memberId) {
                this.submitForm('/api/member/' + memberId, 'edit', 'put');
            },
            view(memberId) {
                window.open("/member/" + memberId, "_blank")
            },
            error(message = null) {
                //Todo: convert error and success to single function
                if (null !== message) {
                    this.$message.error(message);
                } else {
                    this.$message.error('Something went wrong. Sorry.');
                }
            },
            success(message = null) {
                if (null !== message) {
                    this.$message.success(message);
                } else {
                    this.$message.success('Success.');
                }
            }
        },
        mounted() {
            axios.get('/api/member')
                .then((response) => {
                    // handle success
                    this.data = response.data.data.map((item, key) => {
                        return {
                            key: item.id,
                            name: item.attributes.name,
                            joinDate: (new Date(item.attributes.created_at)).toLocaleString(),
                            gamesCount: parseInt(item.attributes.wins) + parseInt(item.attributes.losses),
                            bio: item.attributes.bio,
                            email: item.attributes.email,
                            phoneNumber: item.attributes.phone
                        }
                    });
                })
                .catch((error) => {
                    // handle error
                    console.log(error);
                    this.error();
                });
        },
        components: {
            TheLayout,
            Modal
        }
    }
</script>

<style lang="scss" scoped>
    .button {
        margin: 10px 0 10px;
        font-weight: bold;
    }
</style>
