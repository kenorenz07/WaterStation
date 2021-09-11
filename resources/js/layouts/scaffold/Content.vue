<template>
     <v-main>
        <v-container fluid >
            <v-row justify="start" align="start">
                <v-col >
                    <transition name="fade" mode="out-in">
                        <router-view></router-view>
                    </transition>
                </v-col>
            </v-row>
         </v-container>
    </v-main>
</template>