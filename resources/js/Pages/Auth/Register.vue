<template>
    <jet-dialog-modal :show="show">
        <template #title>
            Add new employee
        </template>

        <template #content>
            <form>
                <div class="col-span-6 sm:col-span-4">
                    <!-- Profile Photo File Input -->
                    <input type="file" class="hidden"
                           ref="photo"
                           @change="updatePhotoPreview">

                    <jet-label for="photo" value="Photo" />

                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                    </div>

                    <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                        Select A New Photo
                    </jet-secondary-button>

                    <jet-input-error :message="form.errors.photo" class="mt-2" />
                </div>


                <div class="mt-4">
                    <jet-label for="name" value="Name"/>
                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                               autocomplete="name"/>
                    <jet-input-error :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-label for="email" value="Email"/>
                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required/>
                    <jet-input-error :message="form.errors.email" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-label for="doj" value="Date of Joining"/>
                    <jet-input id="doj" type="date" class="mt-1 block w-full" v-model="form.doj" required/>
                    <jet-input-error :message="form.errors.doj" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-label for="doq" value="Date of Leaving (Optional)"/>
                    <jet-input id="doq" type="date" class="mt-1 block w-full" v-model="form.doq" required/>
                    <jet-input-error :message="form.errors.doq" class="mt-2" />
                </div>
            </form>
        </template>

        <template #footer>
            <jet-secondary-button @click.native="close">
                Close
            </jet-secondary-button>

            <jet-button @click.native="submit" class="ml-4" :class="{'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </jet-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"

import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import JetDialogModal from "@/Jetstream/DialogModal";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetInputError from "@/Jetstream/InputError";

export default {
    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetInputError,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
        JetSecondaryButton,
        JetDialogModal
    },

    emits: ['close'],
    props: ['show'],

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                doj: '',
                doq: '',
                photo: null,
            }),
            photoPreview: null,
        }
    },

    methods: {
        close() {
            this.$emit('close');
            this.show = false;
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview() {
            const photo = this.$refs.photo.files[0];

            if (! photo) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(photo);
        },

        clearPhotoFileInput() {
            if (this.$refs.photo?.value) {
                this.$refs.photo.value = null;
            }
        },

        submit() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }

            this.form.post(this.route('users.create'), {
                onSuccess: () => {
                    Toastify({
                        text: "New user has been added",
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "bottom", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        onClick: function(){} // Callback after click
                    }).showToast();
                    this.close();
                },
            })
        }
    }
}
</script>
