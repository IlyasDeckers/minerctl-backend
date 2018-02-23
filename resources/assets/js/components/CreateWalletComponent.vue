<template>
<div>
    <div class="col-md-12">
        <form @submit.prevent="generateAddress()" class="form-horizontal" v-show="request">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input class="form-control" type="password" placeholder="Choose a secure password for your wallet" v-model="wallet.password" required>
                            <span class="material-input"></span>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-button text-center">
                    <button type="submit" class="btn btn-fill btn-rose">Generate Wallet</button>
                </div>
            </div>
        </div>
        </form>

        <div class="col-md-12" v-show="download">
            <div class="row text-center">
                <h2>Save your <code>Keystore</code> File.</h2>
                <p><b>Do not lose this file and chosen password! It cannot be recovered!</b> </p>
                <pre><b>address:</b>{{ wallet.encrypted.address }}</pre>
                <div class="form-group form-button">
                    <button type="submit" @click="downloadKeystore()" class="btn btn-fill btn-rose">Download Keystore</button>
                </div>
            </div>
        </div>
    </div>
    <!-- notice modal -->
    <div class="modal fade" id="secwarn" tabindex="-1" role="dialog" aria-labelledby="secwarn" aria-hidden="true">
        <div class="modal-dialog modal-notice">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    <h5 class="modal-title" id="myModalLabel">Security Disclaimer</h5>
                </div>
                <div class="modal-body">
                    <div class="instruction">
                        <div class="row">
                            <div class="col-md-12">

                                <strong>You and only you are responsible for your security.</strong>
                                <ul>
                                    <li>Be diligent to keep your private key and password safe. Your private key is sometimes called your mnemonic phrase, keystore file, UTC file, JSON file, wallet file.</li>
                                    <li>If you lose your private key or password, no one can recover it.</li>
                                    <li>If you enter your private key on a phishing website, you will have <b>all your funds taken.</b></li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="instruction">
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Storing the keys</strong>
                                <p>We never transmit, receive or store your private key, password, or other account information. The handling of your keys happens entirely on your computer, inside your browser. Your keys will be displayed one time. It is your responsibility to store them securely.</p>
                            </div>
                        </div>
                    </div>
                    <div class="instruction">
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Sending keys</strong>
                                <p>If you send your private key to someone, they now have full control of your account. If you send your public key (address) to someone, they can send you ETH or tokens.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <a href="button" class="btn btn-info btn-round" data-dismiss="modal">I Understand</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end notice modal -->
</div>

</template>

<script>
    export default {
        data() {
            return {
                wallet: {
                    privateKey: '',
                    address: '',
                    password: '',
                    encrypted: {}
                },
                download: false,
                request: true
            }
        },
        mounted() {

        },
        methods: {
            generateAddress() {
                var response = web3.eth.accounts.create();
                var wallet = this.wallet;
                console.log(response)
                this.wallet.privateKey = response.privateKey;
                this.wallet.address = response.address;

                this.encryptPrivatekey()
            },
            encryptPrivatekey() {
                this.wallet.encrypted = web3.eth.accounts.encrypt(this.wallet.privateKey, this.wallet.password)
                this.wallet.privateKey = '';
                this.wallet.password = '';

                this.download = true;
                this.request = false;
            },
            downloadKeystore() {
                window.open("data:application/txt," + encodeURIComponent(
                    JSON.stringify(this.wallet.encrypted)), "_self"
                );
            }
        }
    }
</script>
