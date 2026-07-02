

CREATE TABLE public.message_feedback (
    id integer NOT NULL,
    user_id integer NOT NULL,
    conversation_id integer NOT NULL,
    message_id integer NOT NULL,
    document_id integer,
    response_type character varying(10) NOT NULL,
    user_prompt text NOT NULL,
    ai_response text NOT NULL,
    feedback_category character varying(100),
    feedback_text text,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);

ALTER TABLE ONLY public.message_feedback
    ADD CONSTRAINT pk_message_feedback PRIMARY KEY (id);

ALTER TABLE ONLY public.message_feedback
    ADD CONSTRAINT message_feedback_conversation_id_foreign FOREIGN KEY (conversation_id) REFERENCES public.conversations(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY public.message_feedback
    ADD CONSTRAINT message_feedback_document_id_foreign FOREIGN KEY (document_id) REFERENCES public.msfile(fileid) ON UPDATE CASCADE ON DELETE CASCADE;


ALTER TABLE ONLY public.message_feedback
    ADD CONSTRAINT message_feedback_message_id_foreign FOREIGN KEY (message_id) REFERENCES public.messages(id) ON UPDATE CASCADE ON DELETE CASCADE;


ALTER TABLE ONLY public.message_feedback
    ADD CONSTRAINT message_feedback_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.msuser(userid) ON UPDATE CASCADE ON DELETE CASCADE;

