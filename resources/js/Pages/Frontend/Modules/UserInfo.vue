<template>
    <a class="nav-link" href="/dashboard">
        <div class="d-flex">
            <div class="user-nav d-flex flex-column">
                <span class="user-name fw-bolder">{{ $page.props.auth?.user.name }}</span>
                <span class="user-status">{{ $page.props.auth?.user.phone }}</span>
            </div>
            <div class="avatar">
                <img class="round" :src=" $page.props.auth?.user.avatar" alt="avatar" height="40" width="40">
                <span class="avatar-status-online"></span>
            </div>
        </div>
    </a>

<!--    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">-->
<!--        <a class="dropdown-item" href="/dashboard">-->
<!--            <i class="me-50" data-feather="user"></i> Profile-->
<!--        </a>-->
<!--        <a class="dropdown-item" :href="$page.props.auth.MAIN_URL+'/logout'">-->
<!--            <i class="me-50" data-feather="power"></i> Logout-->
<!--        </a>-->
<!--    </div>-->
</template>

<script>
export default {
name: "UserInfo"
}
</script>

<style scoped>

</style>
