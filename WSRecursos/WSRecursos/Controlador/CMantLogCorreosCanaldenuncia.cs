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
    public class CMantLogCorreosCanaldenuncia
    {
        public List<EMantenimiento> MantLogCorreosCanaldenuncia(SqlConnection con,
            Int32 post,
            String ticket,
            String para,
            String copia,
            Int32 anonimo,
            String asunto,
            String archivo,
            String mensaje,
            Int32 output,
            String ruta,
            String user)
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_LOG_CORREOS_DENUNCIA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@ticket", SqlDbType.VarChar).Value = ticket;
            cmd.Parameters.AddWithValue("@para", SqlDbType.VarChar).Value = para;
            cmd.Parameters.AddWithValue("@copia", SqlDbType.VarChar).Value = copia;
            cmd.Parameters.AddWithValue("@anonimo", SqlDbType.Int).Value = anonimo;
            cmd.Parameters.AddWithValue("@asunto", SqlDbType.VarChar).Value = asunto;
            cmd.Parameters.AddWithValue("@archivo", SqlDbType.VarChar).Value = archivo;
            cmd.Parameters.AddWithValue("@mensaje", SqlDbType.VarChar).Value = mensaje;
            cmd.Parameters.AddWithValue("@output", SqlDbType.Int).Value = output;
            cmd.Parameters.AddWithValue("@ruta", SqlDbType.VarChar).Value = ruta;
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