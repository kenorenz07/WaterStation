<template>
    <div>
        <v-container>
            <v-simple-table >
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left">
                                Customer Name
                            </th>
                            <th class="text-left">
                                Date of Review
                            </th>
                            <th class="text-left">
                                Review Modified Date by Customer
                            </th>
                            <th class="text-left">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="review in reviews"
                            :key="review.id"
                        >
                            <td>{{ review.user.name }}</td>
                            <td>{{ moment(review.created_at).calendar() }}</td>   
                            <td>{{ moment(review.updated_at).calendar() }}</td>   
                            <td>
                                <v-icon
                                    class="mr-2"
                                    @click="viewReview(review)"
                                >
                                    mdi-eye
                                </v-icon>
                            </td>                        
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-container>
        <ReviewForm :review="review" :dialogState="review_dialog" @close="review_dialog = false" @reload="getReview"/>

    </div>
</template>
<script>
import ReviewForm from '../../../components/adminForms/Review.vue'

export default {
    data : () => ({
        reviews: [],
        review: {},
        review_dialog: false,
    }),
    components : {
        ReviewForm
    },
    mounted () {
        this.initialize()
    },
    methods : {
        initialize(){
            this.$admin.get('/reviews/all').then(({data}) => {
                this.reviews = data;
            });
        },
        viewReview(review) {
            this.review = review
            this.review_dialog = true
        },
        getReview(){
            this.initialize()
            this.$admin.get('/review/'+this.review.id).then(({data}) => {
                this.review = data
                this.review_dialog = true
            });
        }
    }
}
</script>