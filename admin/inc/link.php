<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<!-- Bootstrap-Icons-->
<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">



<style>
    /* Importing Google font - Poppins */

    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

    :root {
        --teal: #2ec1ac;
        --teal_hover: #279e8c;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        background-image: url("../images/hero-bg.jpg");
        background-position: center;
        background-size: cover;
    }

    h-font {
        font-family: 'Merienda', cursive;
    }

    .custom-bg {
        background-color: var(--teal);
        border: 2px solid var(--teal_hover);
    }

    .custom-bg:hover {
        background-color: var(--teal_hover);
        border: 2px solid var(--teal_hover);
    }

    .availability-form {
        margin-top: -50px;
        z-index: 11;
        position: relative;
        background-color: aliceblue;
    }

    @media screen and(max-width: 575px) {
        .availability-form {
            margin-top: 25px;
            padding: 0 35px;
        }

    }


    swiper-container {
        width: 100%;
        padding-top: 50px;
        padding-bottom: 50px;
    }

    swiper-slide {
        background-position: center;
        background-size: cover;
        width: 300px;
        height: 300px;
    }

    swiper-slide img {
        display: block;
        width: 100%;
    }



    /* User_queries.php (Custom-scrollbar) */

    /* width */
    ::-webkit-scrollbar {
        width: 15px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: black;
        border-radius: 10px;
    }



    /* Facilities.php */
    .h-line {
        width: 150px;
        margin: 0 auto;
        height: 1.7px;
    }

    .pop:hover {
        border-top-color: var(--teal_hover) !important;
        transform: scale(1.03);
        transition: all 0.3s;
    }

    #dashboard-menu {
        z-index: 11;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        display: flex;
        align-items: center;
        flex-direction: column;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(17px);
        --webkit-backdrop-filter: blur(17px);
        border-right: 1px solid rgba(255, 255, 255, 0.7);
        transition: width 0.3s ease;
    }

    @media screen and (max-width :991px) {
        #dashboard-menu {
            height: auto;
            width: 100%;
        }

        #main-content {
            margin-top: 60px;
        }
    }

    /* Essential.php */
    .custom-alert {
        position: fixed;
        top: 80px;
        right: 25px;
    }
</style>