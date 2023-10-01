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
            @{{ club.title }}
            <img :data-src="club.title" class="lazy-load-image"/>
        </div>
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
                },

            })
        </script>
    @endpush
@endsection





