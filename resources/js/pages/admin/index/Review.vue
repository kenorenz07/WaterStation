<template>
    <v-container>
            <v-simple-table >
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left">
                                Customer Name
                            </th>
                            <th class="text-left">
                                Review
                            </th>
                            <th class="text-left">
                                Review At
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="review in reviews"
                            :key="review.id"
                        >
                            <td>{{ review.user.name }}</td>
                            <td>{{ review.review }}</td>
                            <td>{{ moment(review.created_at).calendar() }}</td>                           
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
    </v-container>
</template>
<script>
export default {
    data : () => ({
        reviews: []
    }),
    mounted () {
        this.initialize()
    },
    methods : {
        initialize(){
            this.$admin.get('/reviews/all').then(({data}) => {
                this.reviews = data;
            });
        }
    }
}
</script>