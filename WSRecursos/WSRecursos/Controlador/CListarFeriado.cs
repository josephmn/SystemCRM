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
    public class CListarFeriado
    {
        public List<EListarFeriado> ListarFeriado(SqlConnection con, Int32 post, Int32 id, Int32 anhio)
        {
            List<EListarFeriado> lEListarFeriado = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_FERIADOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarFeriado = new List<EListarFeriado>();

                EListarFeriado obEListarFeriado = null;
                while (drd.Read())
                {
                    obEListarFeriado = new EListarFeriado();
                    obEListarFeriado.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarFeriado.v_descripcion = drd["v_descripcion"].ToString();
                    obEListarFeriado.i_anhio = Convert.ToInt32(drd["i_anhio"].ToString());
                    obEListarFeriado.i_mes = Convert.ToInt32(drd["i_mes"].ToString());
                    obEListarFeriado.v_mes = drd["v_mes"].ToString();
                    obEListarFeriado.d_fecha = drd["d_fecha"].ToString();
                    obEListarFeriado.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarFeriado.v_estado = drd["v_estado"].ToString();
                    obEListarFeriado.v_color_estado = drd["v_color_estado"].ToString();
                    obEListarFeriado.d_fregistro = drd["d_fregistro"].ToString();
                    obEListarFeriado.d_factualiza = drd["d_factualiza"].ToString();
                    lEListarFeriado.Add(obEListarFeriado);
                }
                drd.Close();
            }

            return (lEListarFeriado);
        }
    }
}