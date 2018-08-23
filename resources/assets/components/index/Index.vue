<template>
    <div class="row">
        <div class="col-sm-3">
                
            <div class="xe-widget xe-counter-block" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                <div class="xe-upper">
                    
                    <div class="xe-icon">
                        <i class="linecons-cloud"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">99.9%</strong>
                        <span>Server uptime</span>
                    </div>
                    
                </div>
                <div class="xe-lower">
                    <div class="border"></div>
                    
                    <span>Result</span>
                    <strong>78% Increase</strong>
                </div>
            </div>
            
        </div>
        
        <div class="col-sm-3">
        
            <div class="xe-widget xe-counter-block xe-counter-block-purple" data-count=".num" data-from="0" data-to="512" data-duration="3">
                <div class="xe-upper">
                    
                    <div class="xe-icon">
                        <i class="linecons-camera"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">512</strong>
                        <span>Photos Taken</span>
                    </div>
                    
                </div>
                <div class="xe-lower">
                    <div class="border"></div>
                    
                    <span>Increase</span>
                    <strong>512 more photos</strong>
                </div>
            </div>
            
        </div>
        
        <div class="col-sm-3">
        
            <div class="xe-widget xe-counter-block xe-counter-block-blue" data-suffix="k" data-count=".num" data-from="0" data-to="310" data-duration="4" data-easing="false">
                <div class="xe-upper">
                    
                    <div class="xe-icon">
                        <i class="linecons-user"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">310k</strong>
                        <span>Daily Visits</span>
                    </div>
                    
                </div>
                <div class="xe-lower">
                    <div class="border"></div>
                    
                    <span>Bounce Rate</span>
                    <strong>51.55%</strong>
                </div>
            </div>
            
        </div>
        
        <div class="col-sm-3">
        
            <div class="xe-widget xe-counter-block xe-counter-block-orange">
                <div class="xe-upper">
                    
                    <div class="xe-icon">
                        <i class="fa-life-ring"></i>
                    </div>
                    <div class="xe-label">
                        <strong class="num">24/7</strong>
                        <span>Live Support</span>
                    </div>
                    
                </div>
                <div class="xe-lower">
                    <div class="border"></div>
                    
                    <span>Tickets Opened</span>
                    <strong data-count="this" data-from="0" data-to="14215" data-duration="2">14,215</strong>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        }
    }
</script>
