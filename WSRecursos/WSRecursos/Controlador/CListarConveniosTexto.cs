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
    public class CListarConveniosTexto
    {
        public List<EListarConveniosTexto> ListarConveniosTexto(SqlConnection con, Int32 id)
        {
            List<EListarConveniosTexto> lEListarConveniosTexto = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_CONVENIOS_TEXTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarConveniosTexto = new List<EListarConveniosTexto>();

                EListarConveniosTexto obEListarConveniosTexto = null;
                while (drd.Read())
                {
                    obEListarConveniosTexto = new EListarConveniosTexto();
                    obEListarConveniosTexto.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarConveniosTexto.i_convenio = Convert.ToInt32(drd["i_convenio"].ToString());
                    obEListarConveniosTexto.v_texto = drd["v_texto"].ToString();
                    obEListarConveniosTexto.i_tamanio = Convert.ToInt32(drd["i_tamanio"].ToString());
                    obEListarConveniosTexto.v_color = drd["v_color"].ToString();
                    obEListarConveniosTexto.i_angulo = Convert.ToInt32(drd["i_angulo"].ToString());
                    obEListarConveniosTexto.i_posicionx = Convert.ToInt32(drd["i_posicionx"].ToString());
                    obEListarConveniosTexto.i_posiciony = Convert.ToInt32(drd["i_posiciony"].ToString());
                    lEListarConveniosTexto.Add(obEListarConveniosTexto);
                }
                drd.Close();
            }

            return (lEListarConveniosTexto);
        }
    }
}