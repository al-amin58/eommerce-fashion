<template>
    <transition name="fade">
        <div class="preloader">
            <div class="loading">
                <span data-text="F">F</span>
                <span data-text="A">A</span>
                <span data-text="S">S</span>
                <span data-text="H">H</span>
                <span data-text="I">I</span>
                <span data-text="O">O</span>
                <span data-text="N">N</span>
            </div>
        </div>
    </transition>
</template>
<style lang="scss" scoped>
.preloader {
    width: 100vw;
    position: fixed;
    background: var(--bs-primary);
    z-index: 99999;
}

.loading {
        gap: 20px;
        display: flex;
        font-size: 84px;
        font-weight: 800;
        text-align: center;
        align-items: center;
        span {
            margin: 0 -.05em;
            display: inline-block;
        }
        span {
            position: relative;
            color: rgba(#fff, .2);
            &::after {
                top: 0;
                left: 0;
                opacity: 0;
                position: absolute;
                transform: scale(1.5);
                color: #fff;
                content: attr(data-text);
                animation: loading 3s infinite;
            }
            @for $i from 1 through 7 {
                &:nth-child(#{$i+1})::after {
                    animation-delay: #{$i*.1}s;
                }
            }
        }
    }
    @keyframes loading {
        0%, 75%, 100% {
            transform: scale(1.5);
            opacity: 0;
        }
        25%, 50% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
