crlf macro ; ��ʾ�س�������
    mov  ah,02h
    mov  dl,0dh ; ��ʾ�س�
    int  21h
    mov  ah,02h
    mov  dl,0ah ; ��ʾ����
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
    int 21h ; ��ʾ��ʾ�������Ϣ
    call getnum ; ���ռ�����ֵ�� dx
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
    int 21h ; ���� dos
getnum proc near; �ӳ���, ���ռ�����ֵ�� dx
    push cx     
    xor dx,dx
ggg: 
    mov ah,01h
    int 21h
    cmp al,0dh ; ����Ϊ�س�, �����ת��
    je ppp
    cmp al,20h ; ����Ϊ�ո�, ���˻� dos
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
    mov  cx, 9;��Ҫ�Ľ����-1 
loop1:;ð�ݿ�ʼ 
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
    and  bl,0fh;ȡ����4λ����bl
    shr  al,4
    cmp  bl,09h;�жϵ�λ�Ƿ���a-f�����ڣ����������Ҫ��37h
    jng  add1
    add  bl,07h
add1:
    add  bl,30h;�ѵ�4λ���ɶ�Ӧ��ascii��
    cmp  al,09h;�жϵ�λ�Ƿ���a-f�����ڣ��������в��޸�λ����09h���������ʡ��
    jng  add2
    add  al,07h
add2:
    add  al,30h;�Ѹ�4λ���ɶ�Ӧ��ascii��
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
    and  bl,0fh;ȡ����4λ����bl
    shr  ah,4
    cmp  bl,09h;�жϵ�λ�Ƿ���a-f�����ڣ����������Ҫ��37h
    jng  add3
    add  bl,07h
add3:
    add  bl,30h;�ѵ�4λ���ɶ�Ӧ��ascii��
    cmp  ah,09h;�жϵ�λ�Ƿ���a-f�����ڣ��������в��޸�λ����09h���������ʡ��
    jng  add4
add  ah,07h
add4:
    add  ah,30h;�Ѹ�4λ���ɶ�Ӧ��ascii�� 
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
    mov  cx,40;��Ϊ��ֶ���һ������Ҫ��һ��ѭ��                                      
    mov  si,offset result  
    mov  ah,09h
    mov  dx,offset outm
    int  21h
    crlf                   
dis: ;��ʾ���

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