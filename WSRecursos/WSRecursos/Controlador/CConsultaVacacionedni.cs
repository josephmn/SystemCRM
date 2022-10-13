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
    public class CConsultaVacacionedni
    {
        public List<EConsultaVacacionedni> Listar_ConsultaVacacionedni(SqlConnection con, Int32 post, Int32 id)
        {
            List<EConsultaVacacionedni> lEConsultaVacacionedni = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_VACACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEConsultaVacacionedni = new List<EConsultaVacacionedni>();

                EConsultaVacacionedni obEConsultaVacacionedni = null;
                while (drd.Read())
                {
                    obEConsultaVacacionedni = new EConsultaVacacionedni();
                    obEConsultaVacacionedni.i_id = drd["i_id"].ToString();
                    obEConsultaVacacionedni.v_dni = drd["v_dni"].ToString();
                    obEConsultaVacacionedni.v_nombres = drd["v_nombres"].ToString();
                    obEConsultaVacacionedni.d_ingreso = drd["d_ingreso"].ToString();
                    obEConsultaVacacionedni.v_area = drd["v_area"].ToString();
                    obEConsultaVacacionedni.v_cargo = drd["v_cargo"].ToString();
                    obEConsultaVacacionedni.d_finicio = drd["d_finicio"].ToString();
                    obEConsultaVacacionedni.d_ffin = drd["d_ffin"].ToString();
                    obEConsultaVacacionedni.v_periodo = drd["v_periodo"].ToString();
                    obEConsultaVacacionedni.i_dias = drd["i_dias"].ToString();
                    obEConsultaVacacionedni.v_firma_jefe = drd["v_firma_jefe"].ToString();
                    obEConsultaVacacionedni.v_firma_personal = drd["v_firma_personal"].ToString();
                    lEConsultaVacacionedni.Add(obEConsultaVacacionedni);
                }
                drd.Close();
            }

            return (lEConsultaVacacionedni);
        }
    }
}