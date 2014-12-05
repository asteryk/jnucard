crlf macro ; 显示回车、换行
    mov  ah,02h
    mov  dl,0dh ; 显示回车
    int  21h
    mov  ah,02h
    mov  dl,0ah ; 显示换行
    int  21h
    endm
data segment
mark db ,
mess db ' input your num,press enter to input next num,press space to end!',0dh,0ah,' input:   $'
error db 0dh,0ah, ' input error!',0dh,0ah,'$' 
endh  db 'H',0dh,0ah,'$' 
outm  db 0dh,0ah, 'output is:',0dh,0ah,'$' 
data1 dw 20 dup(0) 
result dw 40 dup(0)
data ends
stack segment stack
sta db 64 dup(0)
top db 0
stack ends
code segment
assume cs:code,ds:data, es:data,ss:stack
start: 
    mov ax,data
    mov ds,ax
    mov es,ax
    mov ax,stack
    mov ss,ax
    lea sp,top  
    mov di,offset data1  
    mov cx,10
head: 
    crlf
    mov mark,0
    mov ah,09h
    lea dx,mess 
    int 21h ; 显示提示输入的信息
    call getnum ; 接收键入数值送 dx
    cmp mark,01h
    je head 
    mov [di],dx
    inc di
    inc di     
loop head  
    call sort 
    call displ   
fini: 
    mov ax,4c00h
    int 21h ; 返回 dos
getnum proc near; 子程序, 接收键入数值送 dx
    push cx     
    xor dx,dx
ggg: 
    mov ah,01h
    int 21h
    cmp al,0dh ; 输入为回车, 则进行转换
    je ppp
    cmp al,20h ; 输入为空格, 则退回 dos
    je fini
    cmp al,30h 
    jb kkk
    sub al,30h
    cmp al,0ah
    jb gets
    cmp al,11h
    jb kkk
    sub al,07h
    cmp al,0fh
    jbe gets 
    cmp al,2ah
    jb kkk
    cmp al,2fh
    ja kkk
    sub al,20h
gets: 
    mov cl,04
    shl dx,cl
    xor ah,ah
    add dx,ax 
    jmp ggg
kkk: 
    mov ah,09h
    mov dx,offset error
    int 21h 
    mov mark,01h
ppp: 
    push dx
    crlf
    pop dx
    pop  cx
    ret
getnum endp 
sort proc near
    mov  cx, 9;需要的结果数-1 
loop1:;冒泡开始 
    mov  di, offset data1
    push cx
loop2:
    mov  ax,[di]
    mov  bx,[di+2]
    cmp  ax,bx
    jnc  next1
    jmp  last
next1:
    mov  [di],bx
    mov  [di+2],ax 
last:
    inc  di
    inc  di
loop     loop2
    pop  cx
loop     loop1  
sort endp 
displ proc near 
    mov  di,offset data1 
    mov  si,offset result
    mov  cx,20
loop3: 
    mov  ax,[di] 
    mov  bl,al
    and  bl,0fh;取出低4位放入bl
    shr  al,4
    cmp  bl,09h;判断低位是否在a-f区间内，如果是则需要加37h
    jng  add1
    add  bl,07h
add1:
    add  bl,30h;把低4位换成对应的ascii码
    cmp  al,09h;判断低位是否在a-f区间内，但题设中并无高位大于09h的情况，可省略
    jng  add2
    add  al,07h
add2:
    add  al,30h;把高4位换成对应的ascii码
    inc  si
    inc  si
    mov  [si],al
    inc  si 
    mov  [si],bl 
    dec  si
    dec  si
    dec  si

;
    mov  bl,ah
    and  bl,0fh;取出低4位放入bl
    shr  ah,4
    cmp  bl,09h;判断低位是否在a-f区间内，如果是则需要加37h
    jng  add3
    add  bl,07h
add3:
    add  bl,30h;把低4位换成对应的ascii码
    cmp  ah,09h;判断低位是否在a-f区间内，但题设中并无高位大于09h的情况，可省略
    jng  add4
add  ah,07h
add4:
    add  ah,30h;把高4位换成对应的ascii码 
    ; 
    inc  di
    inc  di  
    mov  [si],ah
    inc  si 
    mov  [si],bl 
    inc  si  
    inc  si
    inc  si              
loop loop3
    mov  cx,40;因为拆分多了一个数需要多一次循环                                      
    mov  si,offset result  
    mov  ah,09h
    mov  dx,offset outm
    int  21h
    crlf                   
dis: ;显示结果

    mov  bl,4
    mov  ax,cx
    div  bl
    cmp  ah,0 
    jne  fin 
    cmp  cx,40
    je   enter
    mov ah,09h
    mov dx,offset endH
    int 21h 
enter:
    crlf
fin:

    mov  ah,02                                     
    mov  dl,[si] 
    mov  al,0                           
    int  21h

    cmp  cx,1
    jne  fan
    mov ah,09h
    mov dx,offset endH
    int 21h 
fan:
    inc  si                                        
    loop dis 
displ endp     
code ends
  end start