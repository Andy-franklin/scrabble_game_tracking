<template>
    <div>
        <the-layout navKey="2">
            <template v-slot:header>Games</template>
            <template v-slot:content>
                <a-button type="primary" class="button" @click="openModal('add')">Add Game</a-button>
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
        <a-modal title="Add Game" v-model="modalsDisplay.add" @canel="closeModal('add')" @ok="add()">
            <a-form :form="forms.add.form" :label-col="{ span: 8 }" :wrapper-col="{ span: 12 }">
                <a-form-item label="Player One">
                    <a-select style="width: 200px" v-model="forms.add.playerOne">
                        <a-select-option v-for="item in members" :value="item.key" :key="item.key" :data="item">{{ item.name }}</a-select-option>
                    </a-select>
                </a-form-item>
                <a-form-item label="Player One Score">
                    <a-input v-model="forms.add.playerOneScore" type="number"/>
                </a-form-item>
                <a-form-item label="Player Two">
                    <a-select style="width: 200px" v-model="forms.add.playerTwo">
                        <a-select-option v-for="item in members" :value="item.key" :key="item.key" :data="item">{{ item.name }}</a-select-option>
                    </a-select>
                </a-form-item>
                <a-form-item label="Player Two Score">
                    <a-input v-model="forms.add.playerTwoScore" type="number"/>
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
            title: 'Played At',
            dataIndex: 'createdAt',
            key: 'createdAt'
        },
        {
            title: 'Player One',
            dataIndex: 'playerOne',
            key: 'playerOne'
        },
        {
            title: 'Player Two',
            dataIndex: 'playerTwo',
            key: 'playerTwo'
        },
        {
            title: 'Player One Score',
            dataIndex: 'playerOneScore',
            key: 'playerOneScore',
        },
        {
            title: 'Player Two Score',
            dataIndex: 'playerTwoScore',
            key: 'playerTwoScore',
        },
    ];

    export default {
        data() {
            return {
                members: [],
                data: [],
                columns,
                modalsDisplay: {
                    add: false,
                    edit: false,
                },
                forms: {
                    add: {
                        form: this.$form.createForm(this),
                        playerOne: '',
                        playerOneScore: '',
                        playerTwo: '',
                        playerTwoScore: '',
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
                    'player_1': this.forms[formkey].playerOne,
                    'player_1_score': this.forms[formkey].playerOneScore,
                    'player_2': this.forms[formkey].playerTwo,
                    'player_2_score': this.forms[formkey].playerTwoScore
                };

                //Todo: a loading state
                axios[method](endpoint, data).then((response) => {
                    let newData = {
                        key: response.data.data.id,
                        createdAt: (new Date(response.data.data.attributes.created_at)).toLocaleString(),
                        playerOne: response.data.data.relationships.members[0].attributes.name,
                        playerOneScore: response.data.data.relationships.members[0].attributes.score,
                        playerTwo: response.data.data.relationships.members[1].attributes.name,
                        playerTwoScore: response.data.data.relationships.members[1].attributes.score,
                    };


                    this.data.push(newData);

                    this.success();

                    //Reset the form
                    this.forms[formkey].playerOne = '';
                    this.forms[formkey].playerOneScore = '';
                    this.forms[formkey].playerTwo = '';
                    this.forms[formkey].playerTwoScore = '';

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
                this.submitForm('/api/game', 'add', 'post');
            },
            view(gameId) {
                window.open("/game/" + gameId, "_blank")
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
            axios.get('/api/game')
                .then((response) => {
                    // handle success
                    this.data = response.data.data.map((item, key) => {
                        return {
                            key: item.id,
                            createdAt: (new Date(item.attributes.created_at)).toLocaleString(),
                            playerOne: item.relationships.members[0].attributes.name,
                            playerOneScore: item.relationships.members[0].attributes.score,
                            playerTwo: item.relationships.members[1].attributes.name,
                            playerTwoScore: item.relationships.members[1].attributes.score,
                        }
                    });
                })
                .catch((error) => {
                    // handle error
                    console.log(error);
                    this.error();
                });

            axios.get('/api/member')
                .then((response) => {
                    // handle success
                    this.members = response.data.data.map((item, key) => {
                        return {
                            key: item.id,
                            name: item.attributes.name
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
