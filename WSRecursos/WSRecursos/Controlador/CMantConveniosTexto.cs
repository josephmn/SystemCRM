using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CMantConveniosTexto
    {
        public List<EMantenimiento> MantConveniosTexto(SqlConnection con,
            Int32 post,
            Int32 id,
            Int32 iconvenio,
            String texto,
            Int32 tamanio,
            String color,
            Int32 r,
            Int32 g,
            Int32 b,
            Int32 angulo,
            Int32 posicionx,
            Int32 posiciony,
            String user)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_MANT_CONVENIO_TEXTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@iconvenio", SqlDbType.Int).Value = iconvenio;
            cmd.Parameters.AddWithValue("@texto", SqlDbType.VarChar).Value = texto;
            cmd.Parameters.AddWithValue("@tamanio", SqlDbType.Int).Value = tamanio;
            cmd.Parameters.AddWithValue("@color", SqlDbType.VarChar).Value = color;
            cmd.Parameters.AddWithValue("@r", SqlDbType.Int).Value = r;
            cmd.Parameters.AddWithValue("@g", SqlDbType.Int).Value = g;
            cmd.Parameters.AddWithValue("@b", SqlDbType.Int).Value = b;
            cmd.Parameters.AddWithValue("@angulo", SqlDbType.Int).Value = angulo;
            cmd.Parameters.AddWithValue("@posicionx", SqlDbType.Int).Value = posicionx;
            cmd.Parameters.AddWithValue("@posiciony", SqlDbType.Int).Value = posiciony;
            cmd.Parameters.AddWithValue("@user", SqlDbType.VarChar).Value = user;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEMantenimiento = new List<EMantenimiento>();

                EMantenimiento obEMantenimiento = null;
                while (drd.Read())
                {
                    obEMantenimiento = new EMantenimiento();
                    obEMantenimiento.v_icon = drd["v_icon"].ToString();
                    obEMantenimiento.v_title = drd["v_title"].ToString();
                    obEMantenimiento.v_text = drd["v_text"].ToString();
                    obEMantenimiento.i_timer = Convert.ToInt32(drd["i_timer"].ToString());
                    obEMantenimiento.i_case = Convert.ToInt32(drd["i_case"].ToString());
                    obEMantenimiento.v_progressbar = Convert.ToBoolean(drd["v_progressbar"].ToString());
                    lEMantenimiento.Add(obEMantenimiento);
                }
                drd.Close();
            }

            return (lEMantenimiento);
        }
    }
}