<template>
    <div>
        <div class="footer-center-style">
            <p>
                Ⓒ Copyright 2021 | 
                <a href="/">National Council of Churches in Singapore</a>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Footer'
}
</script>

<style>
    .footer-center-style {
        margin-top: 50px;
        text-align: center;
        padding-block: 40px;
        background: #c3c2c2;
    }

    .footer-center-style p a {
        color: #333;
        text-decoration: none;
    }

    .footer-center-style p a:hover {
        text-decoration: underline;
    }

</style>