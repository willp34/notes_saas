console.log("loaded");

jQuery(function ($) {

    const $wrapper = $("#compare-wrapper");
    const $overlay = $("#canvas-overlay");
    const $slider  = $("#slider-handle");

    let dragging = false;

    // ---------------- SLIDER -------------------
    $slider.on("mousedown", function (e) {
        dragging = true;
        e.preventDefault();
    });

    $(document).on("mouseup", () => dragging = false);

    $(document).on("mousemove", function (e) {
        if (!dragging) return;

        let offset = $wrapper.offset().left;
        let x = e.pageX - offset;
        x = Math.max(0, Math.min(x, $wrapper.width()));

        $slider.css("left", x + "px");
        $overlay.css("width", x + "px");
    });


    // ---------------- CANVAS FILTERS ---------------
    const $img = $("#img_src");
    const $canvas = $("#cv");
    const canvas = $canvas[0];
    const ctx = canvas.getContext("2d", { willReadFrequently: true });

    // MAIN: load + prepare canvas
    $img.on("load", function () {

        const img = $img[0];

        // Match canvas to DISPLAYED IMAGE (critical!)
        const w = img.clientWidth;
        const h = img.clientHeight;

        canvas.width  = w;
        canvas.height = h;

        // Draw scaled image
        ctx.drawImage(img, 0, 0, w, h);

        // Match wrapper to same size
        $wrapper.css({ width: w + "px", height: h + "px" });

        // Initial overlay position
        $slider.css("left", (w/2) + "px");
        $overlay.css({
            width: (w/2) + "px",
            height: h + "px"
        });

        // Attach filter change handler
        $("input[name=optradio]").on("change", function () {
					
            // Reset to the ORIGINAL IMAGE every time
            ctx.drawImage(img, 0, 0, w, h);

            let imageData = ctx.getImageData(0, 0, w, h);
            let data = imageData.data;
			console.log("filter ", this.value);
            switch (this.value) {
                case "Pixel manipulation":
                    Pixel_manip(imageData);
                    break;

                case "Floyd":
                    floydSteinberg(imageData);
                    break;

                case "atkinson":
                    atkinson(imageData);
                    break;

                case "threshold":
                    threshold(imageData);
                    break;
            }

            // Put the filtered image back
            ctx.putImageData(imageData, 0, 0);

        });

    });


    //---------------- SUPPORT FUNCTIONS ------------------

    function Pixel_manip(imageData) {
		  let data = imageData.data;
        let level = 128;
        for (let i = 0; i < data.length; i += 4) {
            let avg = (data[i] + data[i+1] + data[i+2]) / 3;
            let v = avg < level ? 0 : 255;
            data[i] = data[i+1] = data[i+2] = v;
        }
    }

    function floydSteinberg(imageData) {
        const { data, width, height } = imageData;

        for (let y = 0; y < height; y++) {
            for (let x = 0; x < width; x++) {

                let i = (y * width + x) * 4;
                let old = toGray(data, i);
                let newVal = old < 128 ? 0 : 255;
                let err = old - newVal;

                data[i] = data[i+1] = data[i+2] = newVal;

                const set = (dx, dy, factor) => {
                    let j = i + (dy * width + dx) * 4;
                    if (j < 0 || j >= data.length) return;

                    let g = toGray(data, j) + err * factor;
                    g = Math.max(0, Math.min(255, g));
                    data[j] = data[j+1] = data[j+2] = g;
                };

                set(1, 0, 7/16);
                set(-1, 1, 3/16);
                set(0, 1, 5/16);
                set(1, 1, 1/16);
            }
        }
    }

    function atkinson(imageData) {
        const { data, width, height } = imageData;

        for (let y = 0; y < height; y++) {
            for (let x = 0; x < width; x++) {

                let i = (y * width + x) * 4;
                let old = toGray(data, i);
                let newVal = old < 128 ? 0 : 255;
                let err = (old - newVal) / 8;

                data[i] = data[i+1] = data[i+2] = newVal;

                const spread = [
                    [1,0],[2,0],
                    [-1,1],[0,1],[1,1],
                    [0,2]
                ];

                for (let [dx, dy] of spread) {
                    let j = i + (dy * width + dx) * 4;
                    if (j < 0 || j >= data.length) continue;

                    let g = toGray(data, j) + err;
                    data[j] = data[j+1] = data[j+2] = Math.max(0, Math.min(255, g));
                }
            }
        }
    }

    function threshold(imageData, threshold = 128) {
		data = imageData.data;
        for (let i = 0; i < data.length; i += 4) {
            let g = toGray(data, i);
            let v = g < threshold ? 0 : 255;
            data[i] = data[i+1] = data[i+2] = v;
        }
    }

    function toGray(data, i) {
        return 0.299 * data[i] + 0.587 * data[i+1] + 0.114 * data[i+2];
    }

});