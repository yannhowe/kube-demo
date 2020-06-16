# Prep OS
```
sudo snap install microk8s --classic --channel=1.18/stable
sudo usermod -a -G microk8s $USER
sudo chown -f -R $USER ~/.kube

su - $USER
microk8s start
microk8s status --wait-ready
microk8s kubectl get nodes
microk8s kubectl get services
microk8s config > ~/.kube/config
echo "alias kubectl='microk8s kubectl'" > ~/.bash_aliases
microk8s enable metallb storage dns registry dashboard metrics-server
```

Input an ip range in the same range as the VM
```
# 192.168.217.150-192.168.217.200
# 192.168.217.201-192.168.217.210
```

## Add insecure registry to docker
```
sudo nano /etc/docker/daemon.json
```
```
# /etc/docker/daemon.json
{
  "insecure-registries" : ["localhost:32000", "platform.net:32000"]
}
```
```
sudo systemctl restart docker
```
Dashboard Token
```
token=$(microk8s kubectl -n kube-system get secret | grep default-token | cut -d " " -f1)
microk8s kubectl -n kube-system describe secret $token
```

Install demo prerequisites
```
kubectl apply -f prereq
```

# Prep Images
Build all images for demo and push to local registry
```
docker pull busybox
docker tag busybox:latest localhost:32000/busybox
docker push localhost:32000/busybox:latest

docker build -t localhost:32000/pod:v1 pod_v1
docker push  localhost:32000/pod:v1

docker build -t localhost:32000/pod:v2 pod_v2
docker push  localhost:32000/pod:v2
```
Save and load for offline if required
```
docker save localhost:32000/busybox:latest -o busybox.tar
docker save  localhost:32000/pod:v1 -o pod_v1.tar
docker save  localhost:32000/pod:v2 -o pod_v2.tar

docker load -i busybox.tar
docker load -i pod_v1.tar
docker load -i pod_v2.tar
```

Clean Up environment
```
kubectl delete -f .
```

# Storytime

Prep screen
- VSC w terminal on left, 


# Kubernetes Dashboard
https://192.168.217.150/#/error?namespace=default

# Generate Load
while true; do wget -q -O- http://192.168.217.151; echo ""; done

# Generate 2x Load
while true; do wget -q -O- http://192.168.217.151/load_2x.php; echo ""; done
