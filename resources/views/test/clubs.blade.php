@extends('layouts.app')
@push('head')
    <style>
        /* Add your CSS styles here */
        .club-card {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
        }

        .lazy-load-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 10px 0;
            opacity: 0.5;
            transition: opacity 0.3s;
        }
    </style>
@endpush
@section('content')
    <div id="app">

        <div v-for="club in clubs" :key="club.id" class="club-card">
            @{{ club.name }}
            <img :data-src="club.name" class="lazy-load-image"/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
        </div>
        <button @click="filterByCategory(2)">2006</button>
        <form @submit.prevent="submitData">
            <input v-model="inputValue" type="text" placeholder="Enter data"/>
            <button type="submit">Submit</button>
        </form>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            var app = new Vue({
                el: '#app',
                data() {
                    return {
                        clubs: [],
                        currentPage: 1,
                        isLoading: false,
                        endOfData: false,
                        inputValue: '',
                    }
                },
                created() {

                    this.fetchClubs();
                    this.setupScrollListener();
                },
                methods: {
                    async fetchClubs() {

                        if (this.isLoading) return;
                        this.isLoading = true;

                        try {
                            const response = await this.fetchClubData(this.currentPage);
                            if (response.data.length === 0) {
                                this.endOfData = true;
                            } else {
                                console.log(response);
                                this.clubs = [...this.clubs, ...response.data]; // Append new data to existing data
                                this.currentPage++;
                            }
                        } catch (error) {
                            console.error('Error fetching data:', error);
                        } finally {
                            this.isLoading = false;
                        }


                    },
                    async fetchClubData(page) {
                        const response = await axios.get(`http://127.0.0.1:8000/test/fetch?page=${page}`);
                        return response.data;

                    },
                    setupScrollListener() {
                        window.addEventListener('scroll', () => {
                            if (
                                window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 200 &&
                                !this.isLoading
                            ) {
                                if (!this.endOfData) {
                                    this.fetchClubs();
                                }
                            }
                        });
                    },
                    filterByCategory(category) {
                        this.clubs = this.clubs.filter(function (item) {
                            return item.language_id === category;
                        });
                        console.log(this.clubs);
                    },
                    submitData() {
                        // Create an object with the input value
                        const data = {
                            value: this.inputValue,
                        };

                        // Make an AJAX request using the fetch API (you can also use Axios or other libraries)
                        fetch('/your-api-endpoint', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data),
                        })
                            .then(response => response.json())
                            .then(responseData => {
                                // Handle the response from the server
                                console.log('Response:', responseData);
                            })
                            .catch(error => {
                                // Handle any errors that occur during the request
                                console.error('Error:', error);
                            });
                    },

                },

            })
        </script>
    @endpush
@endsection





