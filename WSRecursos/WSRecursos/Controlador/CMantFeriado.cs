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
    public class CMantFeriado
    {
        public List<EMantenimiento> MantFeriado(SqlConnection con,
            Int32 post,
            Int32 id,
            String descripcion,
            String fferiado,
            Int32 estado,
            String user
            )
        {
            List<EMantenimiento> lEMantenimiento = null;
            SqlCommand cmd = new SqlCommand("ASP_MANT_FERIADO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@descripcion", SqlDbType.VarChar).Value = descripcion;
            cmd.Parameters.AddWithValue("@fferiado", SqlDbType.VarChar).Value = fferiado;
            cmd.Parameters.AddWithValue("@estado", SqlDbType.Int).Value = estado;
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