
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.querySelector('.ipleak-wp-results');
    const button = document.querySelector('.ipleak-wp-recheck-button');
    const labels = ipleakWPData.labels;

    function getIPInfo() {
        return fetch('https://ipwho.is/')
            .then(res => res.json())
            .catch(() => null);
    }

    function getWebRTCIP() {
        return new Promise((resolve) => {
            let pc = new RTCPeerConnection({ iceServers: [] });
            let ips = new Set();

            pc.createDataChannel('');
            pc.createOffer().then(offer => pc.setLocalDescription(offer));

            pc.onicecandidate = event => {
                if (!event || !event.candidate) {
                    pc.close();
                    resolve(Array.from(ips).join(', ') || 'N/A');
                    return;
                }
                let ipMatch = event.candidate.candidate.match(/([0-9]{1,3}(\.[0-9]{1,3}){3})/);
                if (ipMatch) ips.add(ipMatch[1]);
            };
        });
    }

    function detectDevice() {
        const ua = navigator.userAgent;
        const isMobile = /Mobile|Android|iP(ad|hone)/i.test(ua);
        const os = navigator.platform || 'Unknown';
        const browser = (ua.match(/(Firefox|Chrome|Safari|Edge|Opera)/) || [])[0] || 'Unknown';
        return {
            os,
            browser,
            device: isMobile ? 'Mobile' : 'Desktop'
        };
    }

    function updateUI(data) {
        wrapper.innerHTML = '<table class="ipleak-wp-table">' +
            `<tr><th>${labels.ip_address}</th><td>${data.ip || 'N/A'}</td></tr>` +
            `<tr><th>${labels.location}</th><td>${data.location || 'N/A'}</td></tr>` +
            `<tr><th>${labels.webrtc_ip}</th><td>${data.webrtc || 'N/A'}</td></tr>` +
            `<tr><th>${labels.dns}</th><td>${data.dns || 'N/A'}</td></tr>` +
            `<tr><th>${labels.timezone}</th><td>${data.timezone || 'N/A'}</td></tr>` +
            `<tr><th>${labels.connection}</th><td>${data.connection || 'N/A'}</td></tr>` +
            `<tr><th>${labels.os}</th><td>${data.os}</td></tr>` +
            `<tr><th>${labels.browser}</th><td>${data.browser}</td></tr>` +
            `<tr><th>${labels.device}</th><td>${data.device}</td></tr>` +
            '</table>';
    }

    async function runCheck() {
        wrapper.innerHTML = '<p>' + labels.checking + '</p>';
        const ipInfo = await getIPInfo();
        const webrtcIP = await getWebRTCIP();
        const deviceInfo = detectDevice();

        const data = {
            ip: ipInfo?.ip,
            location: ipInfo ? `${ipInfo.city}, ${ipInfo.region}, ${ipInfo.country}` : 'N/A',
            dns: ipInfo?.connection?.isp || 'N/A',
            timezone: ipInfo?.timezone?.id || 'N/A',
            connection: ipInfo?.connection ? `${ipInfo.connection.domain || ''} (${ipInfo.connection.org || ''})` : 'N/A',
            webrtc: webrtcIP,
            os: deviceInfo.os,
            browser: deviceInfo.browser,
            device: deviceInfo.device
        };

        updateUI(data);
    }

    runCheck();
    if (button) button.addEventListener('click', runCheck);
});
