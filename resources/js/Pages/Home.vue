<template>
    <div class="container flex h-screen">
        <div class="flex flex-col m-auto">
            <div class="flex items-baseline justify-between">
                <div><h2 class="text-lg"> Users </h2></div>
                <div class="flex-shrink-0 ml-4">
                    <button @click.native="showModal"
                            class="shadow px-2 py-1 rounded bg-white hover:bg-gray-200 transition-all">
                        Add New User
                    </button>
                </div>
            </div>
            <div class="mb-20 mt-5 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table v-if="users.length > 0" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Experience
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="person in users" :key="person.email">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" :src="person.profile_photo_url" alt=""/>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ person.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ person.email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ person.title }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ person.experience.y }} Years {{ person.experience.m }} Months
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                        :class="{'bg-red-100 text-red-800' : person.doq, 'bg-green-100 text-green-800' : !person.doq}">
                   {{ person.doq ? 'Quit' : 'Active' }}
                  </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <span @click="deleteUser(person)"
                                          class="text-red-600 hover:text-red-900 cursor-pointer">Delete</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div v-else class="mt-4">
                            <div class="px-6 py-12 bg-white overflow-hidden shadow-md rounded-lg text-gray-600">
                                <div class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-16 w-16">
                                        <path
                                            d="M6 2h6v6c0 1.1.9 2 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2z"
                                            class="fill-current text-gray-300"></path>
                                        <polygon points="14 2 20 8 14 8" class="fill-current text-gray-500"></polygon>
                                    </svg>
                                </div>
                                <div class="mt-4 text-center max-w-xl mx-auto">
                                    No users in the database
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <register :show="show" @close="hideModal"/>
    </div>
</template>

<script>
import Register from "@/Pages/Auth/Register";
import Toastify from "toastify-js";

export default {
    components: {Register},
    props: ['users'],

    data() {
        return {
            show: false,
            form: this.$inertia.form(),
        }
    },

    methods: {
        showModal() {
            this.show = true;
        },

        hideModal() {
            this.show = false;
        },

        deleteUser(user) {
            this.form.delete(this.route('users.delete', user), {
                onSuccess: () => {
                    Toastify({
                        text: "User has been deleted",
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "bottom", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        onClick: function () {
                        } // Callback after click
                    }).showToast();
                },
            })
        }
    }
}
</script>
